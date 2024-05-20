<?php

namespace App\Http\Controllers;

use App\Helpers\Service\ServiceHelper;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    public function show($serviceHash)
    {
        try {
            $service = Service::where('uuid', $serviceHash)->firstOrFail();
            ServiceHelper::verifyService($service);
            $client = $service->clients;

            Log::info("Certificado acessado!", [
                'ip' => request()->ip(),
                'serviceId' => $service->id,
                'clientId' => $client->id,
                'client' => $client->companyName,
            ]);
        } catch (\Exception $e) {
            Log::info("Certificado acessado, Invalido!");
            Log::error($e->getMessage());
            return view('certificates.invalid');
        }

        return view('certificates.valid', compact('service', 'client'));
    }
}
