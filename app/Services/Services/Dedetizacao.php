<?php

namespace App\Services\Services;
use App\Events\ServiceUpdated;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Dedetizacao {
    public const REQUEST_RULES = [
        'products' => 'required|array',
        'value' => 'required|numeric',
        'dateExecution' => 'required|date',
        'dateValidity' => 'required|date|after:dateExecution',
        'description' => 'nullable|string',
        'details' => 'nullable|array',
        'details.local' => 'nullable|string',
    ];

    public static function UpdateDedetizacao(Service $service, Request $request) {
        $payload = $request->validate(self::REQUEST_RULES);
        
        $service->update([
            'products' => json_encode($payload['products']),
            'value' => $payload['value'],
            'details' => json_encode($payload['details']),
            'dateExecution' => Carbon::parse($payload['dateExecution']),
            'dateValidity' => Carbon::parse($payload['dateValidity']),
            'description' => $payload['description'],
            'expired' => 0,
            'created_at' => Carbon::now(),
        ]);

        event(new ServiceUpdated($service));
    }
}