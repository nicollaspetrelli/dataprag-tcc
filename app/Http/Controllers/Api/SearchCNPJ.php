<?php

namespace App\Http\Controllers\Api;

use App\Adapters\Integrations\CNPJ\Providers\BrasilAPI;
use App\Adapters\Integrations\CNPJ\Providers\ReceitaWS;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchCNPJ extends Controller
{
    public function search(string $cnpj): JsonResponse
    {
        $provider = Http::get('https://www.receitaws.com.br/v1/cnpj/' . $cnpj);
        $providerResponse = $provider->json();
        $providerResponseStatus = $providerResponse['status'] ?? null;

        if ($provider->status() === 200 && $providerResponseStatus === "OK") {
            $response = ReceitaWS::adapterToDTO($provider->json());

            return response()->json($response);
        }

        $provider = Http::get('https://brasilapi.com.br/api/cnpj/v1/' . $cnpj);

        if ($provider->status() === 200) {
            $response = BrasilAPI::adapterToDTO($provider->json());

            return response()->json($response);
        }

        return response()->json(['message' => 'CNPJ invalido ou não encontrado'], 404);
    }
}
