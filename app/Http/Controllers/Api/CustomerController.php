<?php

namespace App\Http\Controllers\Api;

use App\Models\Clients;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\DeleteCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Payment;

class CustomerController extends Controller
{
    public function all()
    {
        return Clients::all();
    }

    public function show($id)
    {
        return Clients::findOrFail($id);
    }

    public function store(CreateCustomerRequest $request)
    {
        $client = $request->getDTO();
        $isSaved = $client->save();

        if (!$isSaved) {
            return response()->json([
                'message' => 'Erro ao salvar o cliente',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        Log::info('[API] Cliente criado com sucesso', [
            'client' => $client,
            'user' => auth()->user(),
        ]);
        return response()->json($client, Response::HTTP_ACCEPTED);
    }

    public function update(UpdateCustomerRequest $request)
    {
        $client = $request->getDTO();
        $isSaved = $client->save();

        if (!$isSaved) {
            return response()->json([
                'message' => 'Erro ao atualizar o cliente',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Log::info('[API] Cliente atualizado com sucesso', [
            'client' => $client,
            'user' => auth()->user(),
        ]);

        return response()->json($client, Response::HTTP_ACCEPTED);
    }

    public function delete(DeleteCustomerRequest $request)
    {
        $client = $request->getDTO();

        $services = $client->service;
        $totalServices = $services->count();
        $totalPayments = 0;

        $isServicesDeleted = [];

        $services->each(function ($service) use (&$isServicesDeleted, &$totalPayments) {
            $payment = Payment::where('id', $service->payments_id);

            if ($payment->count() > 0) {
                $isPaymentDeleted = $payment->delete();
                if (!$isPaymentDeleted) {
                    return response()->json([
                        'message' => 'Erro ao deletar o pagamento do serviço',
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
                $totalPayments++;
            }

            array_push($isServicesDeleted, $service->delete());
        });

        if (in_array(false, $isServicesDeleted)) {
            return response()->json([
                'message' => 'Erro ao deletar os serviços do cliente',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $isCustomerDeleted = $client->delete();

        if (!$isCustomerDeleted) {
            return response()->json([
                'message' => 'Erro ao deletar o cliente',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Log::info('[API] Cliente deletado com sucesso', [
            'client' => $client,
            'services' => $totalServices,
            'payments' => $totalPayments,
            'user' => auth()->user(),
        ]);

        return response()->json([
            'message' => 'Cliente deletado com sucesso',
        ], Response::HTTP_ACCEPTED);
    }
}
