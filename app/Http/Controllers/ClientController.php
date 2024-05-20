<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Clients::all();

        //$user = Auth::user();
        return view('pages.clients.index', ['clients' => $clients]);
    }

    /*
    AJAX request
    */
    public function getClients(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $clients = Clients::orderby('companyName', 'asc')->select('id', 'companyName')->limit(10)->get();
        } else {
            $clients = Clients::orderby('companyName', 'asc')->select('id', 'companyName')->where('companyName', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();

        foreach ($clients as $client) {
            $response[] = array(
                "id" => $client->id,
                "text" => $client->companyName
            );
        }

        return json_encode($response);
    }

    /**
     * For datatable Ajax data fetch
     *
     * @return DataTables object
     */
    public function clientsDt(DataTables $dataTables)
    {
        return $dataTables->of(Clients::all())->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $clientType = Clients::getClientType($request->client_type);

        //Client Type Default
        if ($clientType === null) {
            $clientType = intval(Clients::LEGAL);
        }

        return view('pages.clients.create', ['client' => new Clients() ,'clientType' => $clientType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator = $this->validateRequest($request); // Recebe somente dados validados

        // Check validation failure
        if ($validator->fails()) {
            return response(['Error' => 'Unprocessable Entity'], 422);
        }

        $data = $request->all();

        $data['type'] = Clients::getClientType($request->client_type);

        $result = Clients::create($data);

        return response(['NewClientId' => $result->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Clients::findOrFail($id);
        $services = Service::where('clients_id', $client->id)->get();
        $servicesPayment = (new Service())->where('clients_id', $client->id)->where('payments_id', null)->get();
        return view('pages.clients.show', ['client' => $client, 'services' => $services, 'servicesPayment' => $servicesPayment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Clients::findOrFail($id);

        //$clientType = CLients::getClientType($request->client_type);
        return view('pages.clients.edit', ['client' => $client, 'clientType' => $client->type]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Clients::findOrFail($id);

        $validator = $this->validateRequest($request); // Recebe somente dados validados

        // Check validation failure
        if ($validator->fails()) {
            return response(['Error' => 'Unprocessable Entity'], 422);
        }

        $client->update($request->all());

        return response('', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Clients::findOrFail($id);

        $services = Service::where('clients_id', $id)->get();

        $status = $client->delete();

        if ($status && isset($services[0])) {
            foreach ($services as $service) {
                try {
                    $service->delete();
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
        }

        return response('success', 200);
        //return redirect()->route('clientes.index');
    }

    protected function validateRequest($request)
    {
        //$clientType = Clients::getClientType($request->client_type);

        $rules = [
            'companyName' => 'required|max:51',
            'fantasyName' => 'required|max:51',
            'identificationName' => 'required|max:51',
            'documentNumber' => 'required',
            'street' => 'required',
            'neighborhood' => 'required',
            'number' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'notes' => 'max:191',
        ];

        // $rulesIndividual = [
        //     'documentNumber' => 'required|max:255'
        // ];

        // $rulesLegal = [
        //     'documentNumber' => 'required|max:255'
        // ];

        //return $this->validate($request, $clientType == Cliente::TYPE_INDIVIDUAL ? $rules + $rulesIndividual : $rules + $rulesLegal);
        return Validator::make($request->all(), $rules);
    }
}
