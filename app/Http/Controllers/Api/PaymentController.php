<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePaymentRequest;

class PaymentController extends Controller
{
    public function store(CreatePaymentRequest $request): JsonResponse
    {
        $data = $request->all();
        $payment = new Payment();
        $clientId = null;

        foreach ($data['services'] as $serviceId) {
            $serviceModel = Service::findOrFail($serviceId);
            $clientId = $serviceModel->clients_id;
        }

        $payment->clients_id = $clientId;
        $payment->description = $data['paymentDescription'];
        $payment->paymentMethod = $data['paymentMethod'];
        $payment->paymentDate = $data['paymentDate'];
        $payment->totalValue = $data['value'];

        $resultPayment = $payment->save();
        $resultService = false;

        foreach ($data['services'] as $serviceId) {
            $serviceModel = Service::findOrFail($serviceId);
            $serviceModel->payments_id = $payment->id;
            $resultService = $serviceModel->save();
        }

        if (!$resultPayment || !$resultService) {
            return response()->json(['Error on saved payment service' => $resultPayment, 'Error on saved service model' => $resultService], 404);
        }

        Log::info('[DataPrag] Pagamento ID = ' . $payment->id . ' criado por: ' . Auth::user()->email);

        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment,
        ]);
    }
}
