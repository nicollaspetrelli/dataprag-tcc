<?php

namespace App\Helpers\Service;

use App\Models\Clients;
use Carbon\Carbon;
use App\Models\Service;
use Exception;

class ServiceHelper
{
    public static function verifyService(Service $service)
    {
        $client = $service->clients()->first();
        
        if (!$client) {
            throw new Exception('Client not found for the given service.');
        }
        
        $lastService = Service::where('clients_id', $client->id)
                        ->where('documents_id', $service->documents_id)
                        ->whereNull('deleted_at')
                        ->orderByDesc('dateValidity')
                        ->first();

        $now = Carbon::today();
        $endOfMonth = Carbon::today()->addMonth()->endOfMonth();
        $serviceDateValidity = new Carbon($service->dateValidity->toDateString());
        $lastServiceDateValidity = new Carbon($lastService->dateValidity->toDateString());


        if ($serviceDateValidity->lte($lastServiceDateValidity) && ($lastService->id !== $service->id)) {
            $service->expired = 4; // 4 = Data de validade menor que a data de validade do ultimo serviço
            $service->save();
            return;
        }

        // Verifica se a data de validade está dentro do prazo de validade e se não tem um serviço mais recente com validade maior
        if ($serviceDateValidity->lte($now)) {
            $service->expired = 3; // 3 = Data de validade expirada
            $service->save();
            return;
        }

        if ($serviceDateValidity->gte($now) && $serviceDateValidity->lte($endOfMonth)) {
            $service->expired = 2; // 2 = Data de validade proxima a expirar
            $service->save();
            return;
        }

        if ($serviceDateValidity->gte($now)) {
            $service->expired = 1; // 1 = Data de validade dentro do prazo
            $service->save();
            return;
        }

        $service->expired = 0; // 0 = Data de validade não definida
        $service->save();
    }

    public static function verifyCustomerServices(Clients $client)
    {
        $services = $client->service;

        foreach ($services as $service) {
            self::verifyService($service);
        }
    }

    public static function getExpirationStatus(string $dateValidity): int
    {
        $dateValidity = Carbon::parse($dateValidity);

        // Verifica se a data de validade está dentro do prazo de validade
        if ($dateValidity->lte(Carbon::now())) {
            return 2; // 2 = Data de validade expirada
        }

        if ($dateValidity->gte(Carbon::now()) && $dateValidity->lte(Carbon::now()->addMonth()->endOfMonth())) {
            return 1; // 1 = Data de validade proxima a expirar
        }

        return 0;
    }
}
