<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $payments = Payment::all();
        return view('pages.payments.index', ['payments' => $payments]);
    }

    public function generatePayment(Request $request)
    {
        $request->validate([
            'clients_id' => 'required',
            'paymentServices' => 'required',
            'paymentMethod' => 'required',
            'paymentDate' => 'required',
            'totalValue' => 'required',
            'paymentDescription' => 'max:191',
        ]);

        $data = $request->all();

        $payment = new Payment();

        $servicesPrice = [];

        foreach ($data['paymentServices'] as $serviceId) {
            $serviceModel = Service::findOrFail($serviceId);
            $servicesPrice[] = $serviceModel->value;
        }

        $payment->clients_id = $data['clients_id'];
        $payment->description = $data['paymentDescription'];
        $payment->paymentMethod = $data['paymentMethod'];
        $payment->paymentDate = $data['paymentDate'];
        $payment->totalValue = array_sum($servicesPrice);

        $resultPayment = $payment->save();
        $resultService = false;

        foreach ($data['paymentServices'] as $serviceId) {
            $serviceModel = Service::findOrFail($serviceId);
            $serviceModel->payments_id = $payment->id;
            $resultService = $serviceModel->save();
        }

        if (!$resultPayment || !$resultService) {
            return response(['Error on saved payment service' => $resultPayment, 'Error on saved service model' => $resultService], 404);
        }

        Log::info('[DataPrag] Pagamento ID = ' . $payment->id . ' criado por: ' . Auth::user()->email);

        return response(['url' => route('payments.doc', ['paymentId' => $payment->id]), 'insertedPayment' => $resultPayment, 'insertedService' => $resultService], 200);
    }

    public function destroy($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        $results = [];

        $payment->services()->each(function ($service) {
            $service->payments_id = null;
            $results[] = $service->save();
        });

        if (in_array(false, $results)) {
            return response(['Error on delete payment services' => $results], 404);
        }

        $result = $payment->delete();

        if (!$result) {
            return response(['Error on delete payment' => $result], 404);
        }

        return response([$result]);
    }
}
