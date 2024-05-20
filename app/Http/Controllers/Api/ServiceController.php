<?php

namespace App\Http\Controllers\Api;

use App\Events\ServiceCreated;
use App\Events\ServiceDeleted;
use App\Services\Services\Dedetizacao;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Service;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function find($customerId)
    {
        $customer = Clients::findOrFail($customerId);

        $services = $customer->service;

        $allProducts = Products::all();

        foreach ($services as $service) {
            $service->documents_id = intval($service->documents_id);

            if ($service->products === null) {
                $service->products = [];
                continue;
            }

            $productsIdArray = json_decode($service->products);

            // if produtsIdArray cotains one id of allProducts put this product into a new array
            $products = [];
            foreach ($productsIdArray as $productId) {
                foreach ($allProducts as $product) {
                    if ($product->id == $productId) {
                        $products[] = $product->name;
                    }
                }
            }

            $service->products = $products;
        }

        if (empty($services)) {
            return response()->json([
                'message' => 'Nenhum serviço encontrado neste cliente',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($services, Response::HTTP_OK);
    }

    public function all()
    {
        $services = Service::all();

        if (empty($services)) {
            return response()->json([
                'message' => 'Nenhum serviço encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($services, Response::HTTP_OK);
    }

    public function expired(): JsonResponse
    {
        $services = Service::where('expired', 3)->orWhere('expired', 2)->with('clients')->get();

        if (empty($services)) {
            return response()->json([
                'message' => 'Nenhum serviço encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($services, Response::HTTP_OK);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        if (empty($service)) {
            return response()->json([
                'message' => 'Nenhum serviço encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($service, Response::HTTP_OK);
    }

    public function store(StoreServiceRequest $request)
    {
        $customerAndServiceData = $request->getDTO();
        $result = [];

        foreach ($customerAndServiceData->services as $serviceKey => $service) {
            if (!$this->validateServiceType($serviceKey)) {
                return response()->json([
                    'message' => 'Tipo de serviço não informado',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $serviceModel = $this->createService($customerAndServiceData->customer, $serviceKey, $service);
            $result[] = $serviceModel;
            event(new ServiceCreated($serviceModel));
        }

        return response()->json($result, Response::HTTP_OK);
    }

    private function validateServiceType(string $serviceKey): bool
    {
        if (empty($serviceKey)) {
            return false;
        }

        if (!in_array($serviceKey, ['dd', 'dr', 'dc'])) {
            return false;
        }

        return true;
    }

    private function createService(Clients $customer, string $serviceType, array $serviceData): Service
    {
        $service = new Service();
        $service->clients_id = $customer->id;
        $service->documents_id = $this->getDocumentId($serviceType);

        switch ($serviceType) {
            case 'dd':
                return $this->createDedetizacao($serviceData, $service);

            case 'dr':
                return $this->createDedetizacao($serviceData, $service);

            case 'dc':
                return $this->createDesinfeccaoCaixa($serviceData, $service);
        }

        throw new Exception("Error when trying to store a new service");
    }

    private function getDocumentId(string $serviceType): int
    {
        switch ($serviceType) {
            case 'dd':
                return 1;

            case 'dr':
                return 2;

            case 'dc':
                return 3;
        }

        throw new Exception("Error when trying to get document id");
    }

    private function createDedetizacao(array $serviceData, Service $service)
    {
        $service->products = json_encode($serviceData['products']);
        $service->value = $serviceData['value'];

        $service->dateExecution = Carbon::parse($serviceData['date'][0]['startDate']);
        $service->dateValidity = Carbon::parse($serviceData['date'][0]['endDate']);

        if (!empty(trim($serviceData['description']))) {
            $service->description = trim($serviceData['description']);
        }

        if ($service->save()) {
            return $service;
        }
    }

    private function createDesinfeccaoCaixa(array $serviceData, Service $service)
    {
        $service->details = json_encode($serviceData['details']);
        $service->value = $serviceData['value'];

        $service->dateExecution = Carbon::parse($serviceData['date'][0]['startDate']);
        $service->dateValidity = Carbon::parse($serviceData['date'][0]['endDate']);
        $service->description = $serviceData['description'] ?? null;

        if ($service->save()) {
            return $service;
        }
    }

    public function update($id)
    {
        $request = request();
        $service = Service::findOrFail($id);

        $type = $service->documents_id;

        if ($type === 1) {
            Dedetizacao::UpdateDedetizacao($service, $request);
            return response()->json($service, Response::HTTP_OK);
        }

        return response()->json([], Response::HTTP_NOT_IMPLEMENTED);
    }

    public function delete($id)
    {
        $service = Service::findOrFail($id);

        $isDeleted = $service->delete();

        if (!$isDeleted) {
            return response()->json([
                'message' => 'Erro ao deletar serviço',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        event(new ServiceDeleted($service));

        return response()->json([
            'message' => 'Serviço deletado com sucesso',
        ], Response::HTTP_OK);
    }

    public function unpaid(int $customerId): JsonResponse
    {
        // services with join with documents
        $services = Service::where('clients_id', $customerId)
            ->where('payments_id', null)
            ->join('documents', 'services.documents_id', '=', 'documents.id')
            ->select('services.*', 'documents.name as name')
            ->orderBy('dateExecution', 'desc')
            ->get();

        if (empty($services)) {
            return response()->json([
                'message' => 'Nenhum serviço encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($services, Response::HTTP_OK);
    }
}
