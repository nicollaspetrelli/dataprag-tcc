<?php

namespace App\Listeners;

use App\Events\ServiceUpdated;
use App\Models\Service;
use App\Events\ServiceCreated;
use App\Events\ServiceDeleted;
use Illuminate\Support\Facades\Log;
use App\Helpers\Service\ServiceHelper;

class ServicesHandler
{
    public function handleChanged($event)
    {
        Log::info('Serviço criado/alterado', [
            'service' => $event->service,
            'client' => $event->service->clients,
            'user' => auth()->user()->email,
            'time' => now()->format('d/m/Y H:i:s'),
        ]);

        ServiceHelper::verifyCustomerServices($event->service->clients);

        Log::info('Atualização de status do serviço', [
            'service' => $event->service->id,
            'status' => Service::where('id', $event->service->id)->first()->expired,
        ]);
    }

    public function handleDeleted($event)
    {
        ServiceHelper::verifyCustomerServices($event->service->clients);

        Log::info('Serviço removido', [
            'service' => $event->service,
            'client' => $event->service->clients,
            'user' => auth()->user()->email,
            'time' => now()->format('d/m/Y H:i:s'),
        ]);
    }

    public function subscribe($events)
    {
        $events->listen(
            ServiceCreated::class,
            'App\Listeners\ServicesHandler@handleChanged'
        );
        
        $events->listen(
            ServiceUpdated::class,
            'App\Listeners\ServicesHandler@handleChanged'
        );

        $events->listen(
            ServiceDeleted::class,
            'App\Listeners\ServicesHandler@handleDeleted'
        );
    }
}
