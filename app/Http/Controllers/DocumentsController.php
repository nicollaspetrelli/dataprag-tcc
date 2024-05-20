<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Document;
use iio\libmergepdf\Merger;
use Illuminate\Http\Request;
use App\Utils\NumberFormatter;
use Barryvdh\Snappy\PdfWrapper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;

class DocumentsController extends Controller
{
    public function generatePaymentDocument(string $paymentId)
    {
        $data = $this->preparePaymentDocument($paymentId);
        $pdf = $this->generatePdf($data, 'docs.payments');

        try {
            return $pdf->inline($data['fileName']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function preparePaymentDocument(string $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $client = $payment->clients;

        $labeldn = ($client->type) ? 'CPF' : 'CNPJ';
        $labeltipo = ($client->type) ? 'física' : 'jurídica';

        $replaceServices = [];
        $anterior = 0;

        foreach ($payment->services as $service) {
            $replaceServices[] = $service->documents->name;
            $serviceExecutionDates[] = $service->dateExecution->format('d/m/Y');
            if ($anterior === 0) {
                $anterior = $service->dateExecution;
                $servicoMaisRecente = $service->dateExecution;
            } elseif ($service->dateExecution->gte($anterior)) {
                $servicoMaisRecente = $anterior;
            }
        }

        $replaceServices = array_unique($replaceServices);

        $valorTotal = number_format($payment->totalValue, 2, ",", ".");

        if (env('APP_ENV') == 'prod' || env('APP_ENV') == 'homologa') {
            $dataExtenso = utf8_encode($servicoMaisRecente->formatLocalized('%d de %B de %Y'));
        }

        $documentData = [
            'socialname' => $client->companyName,
            'logradouro' => $client->street,
            'numero' => $client->number,
            'bairro' => $client->neighborhood,
            'municipio' => $client->city,
            'cep' => $client->zipcode,
            'labeldn' => $labeldn,
            'labeltipo' => $labeltipo,
            'dn' => $client->documentNumber,
            'dataatual' => $servicoMaisRecente->format('d/m/Y'),
            'dataextenso' => $dataExtenso,
            'valortotal' => $valorTotal,
            'valorextenso' => ucfirst(NumberFormatter::valorPorExtenso($valorTotal, true, false)),
        ];

        foreach ($documentData as $field => $value) {
            $documentData[$field] = htmlspecialchars($value);
        }

        $documentData['services'] = $replaceServices;
        $documentData['fileName'] =  $this->generateFileName('Recibo', $client->companyName);
        return $documentData;
    }

    public function generateMultipleDocuments(Request $request)
    {
        $request->validate([
            "services" => "required|array"
        ]);

        $services = $request->input("services");
        $paths = [];

        $servicesName = implode('e', $services);

        foreach ($services as $serviceId) {
            try {
                $path = storage_path('app/public/generated/' . $serviceId . '.pdf');
                if (file_exists($path)) {
                    $paths[] = $path;
                    continue;
                }

                $data = $this->prepareDocument($serviceId);
                $this->generatePdf($data['documentData'], $data['viewName'])->save($path);
            } catch (\Throwable $th) {
                throw $th;
            }

            $paths[] = $path;
        }

        $firstService = Service::findOrFail($services[0]);

        $clientName =  str_replace('/', '_', $firstService->clients->companyName);
        $fileName = "Documentos - " . $clientName . ".pdf";

        $finalPath = storage_path('app/public/generated/' . $fileName);

        try {
            $merger = new Merger();
            $merger->addIterator($paths);
            $createdPdf = $merger->merge();

            $this->saveBinaryToPDF($createdPdf, $finalPath);

            $randHash = rand(1, 10000000);
            Cache::put($randHash, $finalPath, 120);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }

        return response(["cacheId" => $randHash, "path" => $finalPath, "url" => route("show.document", ['cacheId' => $randHash, 'name' => $fileName])], 200);
    }

    private function saveBinaryToPDF(string $b64, string $finalPath)
    {
        # Write the PDF contents to a local file
        file_put_contents($finalPath, $b64);
    }

    public function stream($cacheId, $fileName)
    {
        $filePath = Cache::get($cacheId);
        // Cache::forget($cacheId);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($fileName) . '"'
        ]);
    }

    public function generateDocument(string $serviceId)
    {
        $path = storage_path('app/public/generated/' . $serviceId . '.pdf');

        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
            ]);
        }

        $data = $this->prepareDocument($serviceId);
        $pdf = $this->generatePdf($data['documentData'], $data['viewName']);

        try {
            $pdf->save($path);

            return $pdf->inline($data['fileName']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function prepareDocument(string $serviceId): array
    {
        $service = Service::findOrFail($serviceId);
        $client = Clients::findOrFail($service->clients->id);

        switch ($service->documents->id) {
            case 1:
                $viewName = 'docs.dedetizacao.all';
                break;
            case 2:
                $viewName = 'docs.desratizacao.all';
                break;
            case 3:
                $viewName = 'docs.desinfeccao.all';
                break;
        }

        $documentData = $this->generateArrayData($service, $client);
        // $path = storage_path('app/public/generated/' . $service->clients->id . '/' . $service->id . '/' . time() . '/' . $documentData['fileName']);

        $documentData['serviceHash'] = $service->uuid;

        return [
            'documentData' => $documentData,
            'viewName' => $viewName,
            'client' => $client,
            'service' => $service,
            'fileName' => $documentData['fileName'],
            // 'path' => $path
        ];
    }

    private function generatePdf(array $documentData, string $viewName): PdfWrapper
    {
        view()->share('documentData', $documentData);
        $pdf = Pdf::loadView($viewName);

        $footer = '<div style="font-family: \'Open Sans\' !important; text-align: center; border-top: 1px solid #ccc; padding: 8px 0;">
                        <span style="font-size: 14px; line-height: 1.5;">Rua: Santo Siviero, 855 - Jd. São Pedro - Araras/SP, CNPJ: 11.675.647/0001-30 - Vig. Sanitária: 350330701-812-000003-1-0.</span><br/>
                        <span>Fones: (19) 3352-5152 / (19) 98255-1200 - E-mail: contato@dedetizadoraambientalis.com</span>
                    </div>';

        $footer = utf8_decode($footer);

        // add footer to pdf
        $pdf->setOption('footer-html', $footer);

        // add margins
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-right', 10);

        return $pdf;
    }

    private function generateArrayData(Service $service, Clients $client): array
    {
        //verifica se é CPF ou CNPJ
        $labeldn = ($client->type) ? 'CPF' : 'CNPJ';

        // calculo de datas
        $dataExecucao = $service->dateExecution;
        $dataValidade = $service->dateValidity;

        $mesesValidadeDigito = $dataExecucao->diffInMonths($dataValidade);

        if ($mesesValidadeDigito <= 9) {
            $mesesValidadeDigito = '0' . $mesesValidadeDigito;
        }

        Carbon::setLocale('pt_BR');

        $mesesValidadeExtenso = NumberFormatter::valorPorExtenso($mesesValidadeDigito, false, false);
        $dataExtenso = $service->dateExecution->formatLocalized('%d de %B de %Y', 'pt_BR');

        if (env('APP_ENV') == 'prod' || env('APP_ENV') == 'homologa') {
            $dataExtenso = utf8_encode($dataExtenso);
        }

        // monta array para o templateProcessor
        $documentData = [
            'socialname' => $client->companyName,
            'logradouro' => $client->street,
            'numero' => $client->number,
            'bairro' => $client->neighborhood,
            'cep' => $client->zipcode,
            'municipio' => $client->city . '-' . $client->state,
            'dn' => $client->documentNumber,
            'labeldn' => $labeldn,
            'dataexecucao' => $service->dateExecution->format('d/m/Y'),
            'datavalidade' => $service->dateValidity->format('d/m/Y'),
            'valmesdigito' => $mesesValidadeDigito,
            'valmesextenso' => $mesesValidadeExtenso,
            'dataextenso' => $dataExtenso,
        ];

        $documentData['fileName'] =  $this->generateFileName($service->documents->name, $client->companyName);

        if ($service->hasProducts()) {
            $products = $service->products();
            $rowArray = [];

            foreach ($products as $product) {
                $description = json_decode($product->description);

                $rowArray[] = [
                    "defensive" => (string) $description->defensives,
                    "chemical" => (string) $description->chemicalGroup,
                    "active" => (string) $description->activeIngredient,
                    "registry" => (string) $product->registryNumber,
                    "class" => (string) $description->toxicologicalClass,
                ];
            }

            $documentData['products'] = $rowArray;
        } else {
            $documentData['products'] = [];
        }


        Log::info($documentData);
        return $documentData;
    }

    private function generateFileName(string $documentName, string $companyName): string
    {
        return $documentName . " - " . str_replace('/', '_', $companyName) . ".pdf";
    }

    public function getAll(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $documents = Document::orderby('name', 'asc')->select('id', 'name')->limit(10)->get();
        } else {
            $documents = Document::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();

        foreach ($documents as $document) {
            $response[] = array(
                "id" => $document->id,
                "text" => $document->name
            );
        }

        return json_encode($response);
    }

    public function testing()
    {
        $print = true;
        $data = ['abc' => '123'];
        view()->share('data', $data);

        if ($print) {
            $pdf = Pdf::loadView('docs.comunicado');

            // $footer = '
            //     <div style="font-family: \'Open Sans\' !important; text-align: center; border-top: 1px solid #ccc; padding: 8px 0;">
            //         <span style="font-size: 14px; line-height: 1.5;">Rua: Santo Siviero, 855 - Jd. São Pedro - Araras/SP, CNPJ: 11.675.647/0001-30 - Vig. Sanitária: 350330701-812-000003-1-0.</span><br/>
            //         <span>Fones: (19) 3352-5152 / (19) 98255-1200 - E-mail: contato@dedetizadoraambientalis.com</span>
            //     </div>
            //     ';

            // $footer =  view('docs.comunicado.footer');

            // $footer = utf8_decode($footer);

            // // add footer to pdf
            // $pdf->setOption('footer-html', $footer);

            // add margins
            $pdf->setOption('margin-top', 0);
            $pdf->setOption('margin-bottom', 0);
            $pdf->setOption('margin-left', 0);
            $pdf->setOption('margin-right', 0);

            return $pdf->stream('teste.pdf');
        } else {
            return view('docs.comunicado');
        }
    }
}
