<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Document;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        # dashboard
        // Total de clientes, ganhso, novos serviços, contato pendente

        $totalClients = Clients::count();
        $totalServices = Service::where('created_at', '>=', Carbon::now()->subMonth()->endOfMonth())->count();
        $earnings = Payment::where('created_at', '>=', Carbon::now()->subMonth()->endOfMonth())->sum('totalValue');
        $contactPending = DB::table('services')->select('clients_id')->where('expired', '>=', '1')->groupBy('clients_id')->get();
        $contactPending = count($contactPending);

        $dashboard = [
            'totalClients' => $totalClients,
            'totalServices' => $totalServices,
            'earnings' => $earnings,
            'contactPending' => $contactPending
        ];

        # Serviços Pendentes
        $serviceModel = new Service();
        $services = Service::where('expired', '>=', '1')->get();

        return view('pages.painel', ['services' => $services, 'serviceModel' => $serviceModel, 'dashboard' => $dashboard]);
    }

    public function calculateTypesOfServices()
    {
        $services = [];

        $documents = Document::all();

        foreach ($documents as $document) {
            $services[] = Service::where('documents_id', $document->id)->count();
        }

        return response()->json($services);
    }

    public function calculateRevenue()
    {
        $revenue = [];
        $year = Carbon::now()->year;

        $months = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        // calculate revenue of each month
        for ($i = 1; $i <= 12; $i++) {
            $month = $months[$i];

            $start = new Carbon('first day of ' . $month . $year);
            $end = new Carbon('last day of ' . $month . $year);

            $revenue[] = Payment::where('created_at', '>=', $start)->where('created_at', '<=', $end)->sum('totalValue');
        }

        return response()->json($revenue);
    }
}
