<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Payment;
use App\Models\Service;
use iio\libmergepdf\Merger;
use App\Utils\NumberFormatter;
use Barryvdh\Snappy\PdfWrapper;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Illuminate\Support\Facades\Crypt;

class DocumentsService
{
    private const SINGLE_FILES_STORAGE_PATH = 'app/files/';
    private const SINGLE_PAYMENT_FILES_STORAGE_PATH = 'app/files/payments/';
    private const MERGED_FILES_STORAGE_PATH = 'app/files/merged/';

    public function saveDocument(string $serviceId)
    {
        $path = $this->generateSingleFilePath($serviceId);

        if (file_exists($path)) {
            return;
        }

        $data = $this->prepareDocument($serviceId);
        $pdf = $this->generatePdf($data['documentData'], $data['viewName']);
        $pdf->save($path);

        if (file_exists($path)) {
            return;
        }

        throw new Exception('Não foi possível salvar o arquivo');
    }

    public function savePaymentReceipt(Payment $payment)
    {
        $path = $this->generatePaymentReceiptPath($payment);

        if (file_exists($path)) {
            return;
        }

        $data = $this->preparePaymentReceipt($payment);
        $pdf = $this->generatePdf($data['documentData'], $data['viewName']);
        $pdf->save($path);

        if (file_exists($path)) {
            return;
        }

        throw new Exception('Não foi possível salvar o arquivo');
    }

    public function mergeDocuments(array $serviceIds, array $paymentIds = [])
    {
        $paths = $this->getPathsFromServiceIds($serviceIds);

        if (count($paymentIds) > 0) {
            $paths = array_merge($paths, $this->getPathsFromPaymentIds($paymentIds));
        }

        $merger = new Merger();

        foreach ($paths as $path) {
            $merger->addFile($path);
        }

        $createdPdf = $merger->merge();

        $mergedFilePath =  $this->generateMergedFilesPath($serviceIds, $paymentIds);

        $this->saveBinaryToPDF($createdPdf, $mergedFilePath);

        if (file_exists($mergedFilePath)) {
            return;
        }

        return throw new Exception('Não foi possível fazer o merge dos arquivos');
    }

    public function generateSingleFileSecretLink(string $serviceId): string
    {
        $service = Service::findOrFail($serviceId);
        $client = Clients::findOrFail($service->clients_id);

        $serviceHash = $service->uuid;
        $fileName = $this->generateFileName($service->documents->name, $client->companyName);

        $baseUrl = env('APP_URL') . "/doc/$serviceHash/$fileName";

        return $baseUrl;
    }

    public function generatePaymentReceiptSecretLink(Payment $payment): string
    {
        $client = $payment->clients;

        $paymentIdEncrypted = Crypt::encryptString($payment->id);

        $fileName = $this->generateFileName('Recibo de Pagamento', $client->companyName);

        $baseUrl = env('APP_URL') . "/receipt/$paymentIdEncrypted/$fileName";

        return $baseUrl;
    }

    public function generateMergedFileSecretLink(array $serviceIds, array $paymentsIds = []): string
    {
        $service = Service::findOrFail($serviceIds[0]);
        $client = Clients::findOrFail($service->clients_id);

        $serviceSlug = implode('', $serviceIds);

        if (count($paymentsIds) > 0) {
            $serviceSlug .= 'pay' . implode('', $paymentsIds);
        }

        $fileName = $this->generateFileName('Documentos', $client->companyName);

        $baseUrl = env('APP_URL') . "/docs/$serviceSlug/$fileName";

        return $baseUrl;
    }

    private function getPathsFromServiceIds(array $serviceIds)
    {
        $paths = [];

        foreach ($serviceIds as $serviceId) {
            $path = $this->generateSingleFilePath($serviceId);

            if (!file_exists($path)) {
                continue;
            }

            $paths[] = $path;
        }

        if (count($paths) !== count($serviceIds)) {
            throw new Exception('Não foi possível encontrar o caminho dos arquivos');
        }

        return $paths;
    }

    private function getPathsFromPaymentIds(array $paymentsId)
    {
        $paths = [];

        foreach ($paymentsId as $paymentId) {
            $payment = Payment::findOrFail($paymentId);

            $path = $this->generatePaymentReceiptPath($payment);

            if (!file_exists($path)) {
                continue;
            }

            $paths[] = $path;
        }

        if (count($paths) !== count($paymentsId)) {
            throw new Exception('Não foi possível encontrar o caminho dos arquivos');
        }

        return $paths;
    }

    private function saveBinaryToPDF(string $b64, string $finalPath)
    {
        file_put_contents($finalPath, $b64);
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
        $fileName = $this->generateFileName($service->documents->name, $client->companyName);
        $documentData['fileName'] = $fileName;

        return [
            'documentData' => $documentData,
            'serviceId' => $serviceId,
            'viewName' => $viewName,
            'client' => $client,
            'service' => $service,
            'fileName' => $fileName,
        ];
    }

    private function preparePaymentReceipt(Payment $payment): array
    {
        $client = $payment->clients;

        $labeldn = ($client->type) ? 'CPF' : 'CNPJ';
        $labeltipo = ($client->type) ? 'física' : 'jurídica';

        $dataExtenso = $payment->paymentDate->formatLocalized('%d de %B de %Y');
        $valorTotal = number_format($payment->totalValue, 2, ",", ".");

        $servicesLabel = [];
        foreach ($payment->services as $service) {
            $servicesLabel[] = $service->documents->name;
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
            'dataatual' => $payment->paymentDate->format('d/m/Y'),
            'dataextenso' => $dataExtenso,
            'valortotal' => $valorTotal,
            'services' => array_unique($servicesLabel),
            'valorextenso' => ucfirst(NumberFormatter::valorPorExtenso($valorTotal, true, false)),
        ];

        foreach ($documentData as $field => $value) {
            if (is_string($value)) {
                $documentData[$field] = htmlspecialchars($value);
            }
        }

        $documentData['fileName'] = $this->generateFileName('Recibo de Pagamento', $client->companyName);

        return [
            'documentData' => $documentData,
            'payment' => $payment,
            'viewName' => 'docs.payments',
            'client' => $client,
            'service' => $service
        ];
    }

    private function generatePdf(array $documentData, string $viewName): PdfWrapper
    {
        view()->share('documentData', $documentData);
        $pdf = Pdf::loadView($viewName);

        // add margins
        $pdf->setOption('margin-top', 10);
        $pdf->setOption('margin-bottom', 20);
        $pdf->setOption('margin-left', 10);
        $pdf->setOption('margin-right', 10);

        // add size
        $pdf->setOption('page-size', 'A4');
        $pdf->setOption('page-width', '210mm');
        $pdf->setOption('page-height', '297mm');

        $footer = '<div style="font-family: \'Open Sans\' !important; text-align: center; border-top: 1px solid #ccc; padding: 8px 0;">
                        <span style="font-size: 14px; line-height: 1.5;">Rua: Santo Siviero, 855 - Jd. São Pedro - Araras/SP, CNPJ: 11.675.647/0001-30 - Vig. Sanitária: 350330701-812-000003-1-0.</span><br/>
                        <span>Fones: (19) 3352-5152 / (19) 98255-1200 - E-mail: contato@dedetizadoraambientalis.com</span>
                    </div>';

        $footer = utf8_decode($footer);

        // add footer to pdf
        $pdf->setOption('footer-html', $footer);

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
        $dataExtenso = $service->dateExecution->formatLocalized('%d de %B de %Y');

        // if (env('APP_ENV') == 'prod' || env('APP_ENV') == 'homologa') {
        //     $dataExtenso = utf8_encode($dataExtenso);
        // }

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
            'serviceHash' => $service->uuid,
        ];

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

        return $documentData;
    }

    private function generateFileName(string $documentName, string $companyName): string
    {
        return $documentName . " - " . str_replace('/', '_', $companyName) . ".pdf";
    }

    private function generateSingleFilePath(string $serviceId): string
    {
        return storage_path(self::SINGLE_FILES_STORAGE_PATH . $serviceId . '.pdf');
    }

    public function generatePaymentReceiptPath(Payment $payment): string
    {
        return storage_path(self::SINGLE_PAYMENT_FILES_STORAGE_PATH . $payment->id . '.pdf');
    }

    public function generateMergedFilesPath(array $serviceIds, array $paymentsIds = []): string
    {
        $implodeOfIds = implode('', $serviceIds);

        if (!empty($paymentsIds)) {
            $implodeOfIds .= 'pay' . implode('', $paymentsIds);
        }

        return storage_path(self::MERGED_FILES_STORAGE_PATH . $implodeOfIds . '.pdf');
    }
}
