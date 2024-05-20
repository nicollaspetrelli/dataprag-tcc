<?php

namespace App\Adapters\Integrations\CNPJ\Providers;

use App\DTO\SearchCNPJDocument;
use Illuminate\Support\Carbon;

class BrasilAPI
{
    public static function adapterToDTO(array $providerResponse): SearchCNPJDocument
    {
        return new SearchCNPJDocument(
            documentNumber: $providerResponse['cnpj'],
            companyName: $providerResponse['razao_social'],
            fantasyName: $providerResponse['nome_fantasia'],
            zipCode: $providerResponse['cep'],
            street: $providerResponse['logradouro'],
            number: $providerResponse['numero'],
            complement: $providerResponse['complemento'],
            neighborhood: $providerResponse['bairro'],
            city: $providerResponse['municipio'],
            state: $providerResponse['uf'],
            source: 'BrasilAPI',
            lastUpdateAt: Carbon::parse($providerResponse['data_situacao_cadastral'])
        );
    }
}
