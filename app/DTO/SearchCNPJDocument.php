<?php

namespace App\DTO;

use Illuminate\Support\Carbon;

class SearchCNPJDocument
{
    public function __construct(
        public string $documentNumber,
        public string $companyName,
        public string $fantasyName,
        public string $zipCode,
        public string $street,
        public string $number,
        public string $complement,
        public string $neighborhood,
        public string $city,
        public string $state,
        public string $source,
        public ?Carbon $lastUpdateAt = null
    ) {
    }

    // to array
    public function toArray(): array
    {
        return [
            'documentNumber' => $this->documentNumber,
            'companyName' => $this->companyName,
            'fantasyName' => $this->fantasyName,
            'zipCode' => $this->zipCode,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'source' => $this->source,
            'lastUpdateAt' => $this->lastUpdateAt->format('Y-m-d H:i:s') ?? null,
        ];
    }
}
