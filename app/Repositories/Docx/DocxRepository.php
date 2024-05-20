<?php

namespace App\Repositories\Docx;

use Exception;
use App\Models\Clients;
use App\Models\Payment;
use App\Models\Service;
use App\Utils\NumberFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DocxRepository
{
    public function generateWordDoc(string $serviceId): string
    {
        $service = Service::findOrFail($serviceId);
        $client = Clients::findOrFail($service->clients->id);

        $templateFile = Storage::path($service->documents->path);
        $templateProcessor = new TemplateProcessor($templateFile);

        //prepara os dados
        $labeldn = ($client->type) ? 'CPF' : 'CNPJ';

        // calculo de datas
        $dataExecucao = $service->dateExecution;
        $dataValidade = $service->dateValidity;

        $mesesValidadeDigito = $dataExecucao->diffInMonths($dataValidade);

        if ($mesesValidadeDigito <= 9) {
            $mesesValidadeDigito = '0' . $mesesValidadeDigito;
        }

        $mesesValidadeExtenso = NumberFormatter::valorPorExtenso($mesesValidadeDigito, false, false);
        //$mesesValidadeExtenso = ucfirst($mesesValidadeExtenso);

        $dataExtenso = $service->dateExecution->formatLocalized('%d de %B de %Y', 'pt_BR');

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

        foreach ($documentData as $field => $value) {
            $documentData[$field] = htmlspecialchars($value);
        }

        if ($service->hasProducts()) {
            $products = $service->products();
            $rowArray = [];

            foreach ($products as $product) {
                $description = json_decode($product->description);

                $rowArray[] = [
                    "p.defensive" => (string) $description->defensives,
                    "p.chemical" => (string) $description->chemicalGroup,
                    "p.active" => (string) $description->activeIngredient,
                    "p.registry" => (string) $product->registryNumber,
                    "p.class" => (string) $description->toxicologicalClass,
                    "p.ia" => (string) $description->percentage . "%",
                ];
            }

            $templateProcessor->cloneRowAndSetValues('p.defensive', $rowArray);
        } else {
            // TODO: default caso nao tenha produtos
        }

        // Insere os dados no template
        $templateProcessor->setValues($documentData);

        $docName = $this->generateDocName($service->documents->name, $client);

        $finalPatch = storage_path('app/public/' . $docName);

        Log::debug('Gerando arquivo: ' . $finalPatch);

        try {
            $templateProcessor->saveAs($finalPatch);
        } catch (Exception $e) {
            dd($e);
        }

        return $finalPatch;
    }

    public function generatePaymentDoc(string $paymentId): string
    {
        $payment = Payment::findOrFail($paymentId);
        $client = $payment->clients;

        //prepara os dados
        $labeldn = ($client->type) ? 'CPF' : 'CNPJ';
        $labeltipo = ($client->type) ? 'física' : 'juridica';

        $templateFile = Storage::path('public/docs/templates/RECIBO.docx');
        $templateProcessor = new TemplateProcessor($templateFile);

        $anterior = 0;
        foreach ($payment->services as $service) {
            // Guardando nome dos serviços
            $replaceServices[]['servicename'] = $service->documents->name;
            $serviceExecutionDates[] = $service->dateExecution->format('d/m/Y');
            if ($anterior === 0) {
                $anterior = $service->dateExecution;
                $servicoMaisRecente = $service->dateExecution;
            } elseif ($service->dateExecution->gte($anterior)) {
                $servicoMaisRecente = $anterior;
            }
        }

        $valorTotal = number_format($payment->totalValue, 2, ",", ".");

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
            'dataextenso' => $servicoMaisRecente->formatLocalized('%d de %B de %Y'),
            'valortotal' => $valorTotal,
            'valorextenso' => ucfirst(NumberFormatter::valorPorExtenso($valorTotal, true, false))
        ];

        foreach ($documentData as $field => $value) {
            $documentData[$field] = htmlspecialchars($value);
        }

        // Setando Dados
        $templateProcessor->setValues($documentData);

        // Create Services Part in Document
        $templateProcessor->cloneBlock('services_block', 0, true, false, $replaceServices);

        $docName = $this->generateDocName('Recibo', $client);
        $finalPatch = storage_path('app/public/' . $docName);

        try {
            $templateProcessor->saveAs($finalPatch);
        } catch (\Exception $e) {
            dd($e);
        }

        return $finalPatch;
    }

    private function generateDocName(string $docType, Clients $client): string
    {
        $name = str_replace('/', '_', $client->companyName);
        return $docType . " - " . $name . ".docx";
    }
}
