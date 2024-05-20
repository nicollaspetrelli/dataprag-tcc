<?php

namespace App\Adapters\Integrations\CNPJ\Providers;

use App\DTO\SearchCNPJDocument;
use Illuminate\Support\Carbon;

class ReceitaWS
{
    public static function adapterToDTO(array $providerResponse): SearchCNPJDocument
    {
        $cnpj = $providerResponse['cnpj'];
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        $zipCode = $providerResponse['cep'];
        $zipCode = preg_replace('/[^0-9]/', '', $zipCode);

        return new SearchCNPJDocument(
            documentNumber: $cnpj,
            companyName: $providerResponse['nome'],
            fantasyName: $providerResponse['fantasia'],
            zipCode: $zipCode,
            street: $providerResponse['logradouro'],
            number: $providerResponse['numero'],
            complement: $providerResponse['complemento'],
            neighborhood: $providerResponse['bairro'],
            city: $providerResponse['municipio'],
            state: $providerResponse['uf'],
            source: 'ReceitaWS',
            lastUpdateAt: Carbon::parse($providerResponse['ultima_atualizacao'])
        );
    }
}
