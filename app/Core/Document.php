<?php

namespace App\Core;

use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;

class Document
{
    public function __construct(
        private ?string $footer = null,
        private string $fileName,
        private array $documentData,
        private array $marginOptions,
        private string $bladeTemplateViewName,
        private bool $saveFile = false
    ) {
    }

    public function generatePDF()
    {
        $this->makePdfObject();
        $this->setMargins();

        if ($this->hasFooter()) {
            $this->setFooter();
        }

        if ($this->saveFile) {
            $this->saveFile();
        }

        return $this->pdfObject->stream($this->getFileNameWithExtension());
    }

    private function saveFile()
    {
        $this->pdfObject->save($this->getFullPath());
    }

    private function makePdfObject()
    {
        view()->share('documentData', $this->documentData);
        $this->pdfObject = Pdf::loadView($this->bladeTemplateViewName);
    }

    private function setMargins()
    {
        $this->pdfObject->setOption('margin-top', $this->marginOptions['margin-top']);
        $this->pdfObject->setOption('margin-bottom', $this->marginOptions['margin-bottom']);
        $this->pdfObject->setOption('margin-left', $this->marginOptions['margin-left']);
        $this->pdfObject->setOption('margin-right', $this->marginOptions['margin-right']);
    }

    private function setFooter()
    {
        $this->pdfObject->setOption('footer-html', utf8_decode($this->footer));
    }

    public function getFileNameWithExtension(): string
    {
        // maybe need to convert to utf8 utf8_decode()
        return $this->fileName . '.pdf';
    }

    private function getFullPath(): string
    {
        return storage_path('app/public/generated/' . $this->getFileNameWithExtension());
    }

    private function hasFooter(): bool
    {
        return $this->footer !== null;
    }
}
