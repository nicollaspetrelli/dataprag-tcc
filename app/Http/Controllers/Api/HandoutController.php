<?php

namespace App\Http\Controllers\Api;

use App\Core\Document;
use App\Http\Controllers\Controller;
use App\Http\Requests\HandoutRequest;

class HandoutController extends Controller
{
    private const VIEW_NAME = 'docs.comunicado.handout';

    public function show(HandoutRequest $request)
    {
        $this->handout = $request->getDto();

        return $this->generateHandout();
    }

    public function generateHandout()
    {
        $fantasyName = $this->handout->hasCustomName() ? $this->handout->customName : $this->handout->client->fantasyName;

        $dateLabel = $this->generateDateLabel();

        $document = new Document(
            fileName: $this->generateFileName($fantasyName),
            bladeTemplateViewName: self::VIEW_NAME,
            documentData: [
                'fantasyName' => $fantasyName,
                'date' => $dateLabel,
            ],
            marginOptions: [
                'margin-top' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,
                'margin-right' => 0,
            ],
            saveFile: false,
        );

        return $document->generatePDF();
    }

    private function generateDateLabel(): string
    {
        if ($this->handout->hasCustomDateLabel()) {
            return $this->handout->customDateLabel;
        }

        $startDate = $this->handout->startDate->format('d/m/Y');
        $startTime = $this->handout->startDate->format('H:i');

        if (!$this->handout->hasPeriod()) {
            return "Dia: {$startDate} às {$startTime}hrs";
        }

        $endDate = $this->handout->endDate->format('d/m/Y');
        $endTime = $this->handout->endDate->format('H:i');

        return "Dia: {$startDate} às {$startTime}hrs e {$endDate} ás {$endTime}hrs";
    }

    private function generateFileName(string $name): string
    {
        return "{$name} - Comunicado";
    }
}
