<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Service;
use App\Models\Document;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Service\ServiceHelper;

class ServiceController extends Controller
{
    public function __construct(Service $serviceModel)
    {
        $this->middleware('auth');
        $this->serviceModel = $serviceModel;
    }

    public function index()
    {
        $services = Service::all();

        if ($services->isEmpty()) {
            return view('pages.services.index', ['services' => $this->serviceModel]);
        }

        return view('pages.services.index', ['services' => $services]);
    }

    public function selectClientToCreate()
    {
        return view('pages.clients.create', ['client' => new Clients(), 'clientType' => 1]);
    }

    public function createByClient($id)
    {
        $client = Clients::findOrFail($id);

        $products[1] = Products::whereJsonContains('category', "1")->get();
        $products[2] = Products::whereJsonContains('category', "2")->get();

        $service = new Service();
        return view('pages.services.create', ['client' => $client, 'service' => $service, 'products' => $products]);
    }

    public function getServicesByClient($id)
    {
        $client = Clients::findOrFail($id);
        $services = new Service();

        return $services->where('clients_id', $client->id);
    }

    public function getServices(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $services = Document::orderby('name', 'asc')->select('id', 'name')->limit(5)->get();
        } else {
            $services = Document::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();

        foreach ($services as $service) {
            $response[] = array(
                "id" => $service->id,
                "text" => $service->name
            );
        }

        return json_encode($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'clients_id' => 'required',
            'documents_id' => 'array|required',
        ]);

        $data = $request->all();
        $documents = $data['documents_id'];

        $result = [];
        $serviceIds = [];

        foreach ($documents as $documentId) {
            $valueField = "valueIntDoc" . $documentId;
            $descriptionField = "description-doc" . $documentId;
            $productField = "products-" . $documentId;

            $request->validate([
                $valueField => 'required|max:8',
                $descriptionField => 'max:255',
            ]);

            if ($documentId != 3) {
                $request->validate([
                    $productField => 'required|array',
                ]);
            }

            $dateExecution = "startDoc" . $documentId;
            $dateValidity = "endDoc" . $documentId;

            $service = new Service();
            $service->clients_id = $data['clients_id'];
            $service->documents_id = $documentId;
            $service->value = $data[$valueField];

            if ($documentId != 3) {
                $service->products = json_encode($data[$productField]);
            }

            $service->dateExecution = $data[$dateExecution];
            $service->dateValidity = $data[$dateValidity];

            $service->expired = ServiceHelper::getExpirationStatus($data[$dateValidity]);

            if (isset($data[$descriptionField])) {
                $service->description = $data[$descriptionField];
            }

            $result[] = $service->save();
            $serviceIds[] = $service->id;
        }

        if (!$result[0]) {
            return response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $logIds = implode(', ', $serviceIds);
        $userEmail = Auth::user()->email;

        Log::info("[DataPrag] Serviços ID= " . $logIds  . " criado pelo usuario: " . $userEmail);

        return response(["serviceIds" => $serviceIds], Response::HTTP_OK);
    }

    public function show($id)
    {
        // TODO: Make dialog to show service details
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $client = $service->clients;

        $products[$service->documents_id] = Products::whereJsonContains('category', "$service->documents_id")->get();

        return view('pages.services.edit', compact('service', 'client', 'products'));
    }

    public function update(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        $request->validate([
            'clients_id' => 'required',
            'value' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'max:190',
        ]);

        $data = $request->all();

        if ($service->documents_id !== 3) {
            $request->validate([
                'products' => 'required|array',
            ]);

            $service->products = json_encode($data['products']);
        }

        $service->dateExecution = $data['start'];
        $service->dateValidity = $data['end'];
        $service->value = $data['value'];

        if (isset($data['description'])) {
            $service->description = $data['description'];
        }

        $result = $service->save();

        return response([$result], 200);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        Log::info("[DataPrag] Serviço ID= " . $id  . " excluido pelo usuario: " . Auth::user()->email);
        return response('', Response::HTTP_NO_CONTENT);
    }
}
