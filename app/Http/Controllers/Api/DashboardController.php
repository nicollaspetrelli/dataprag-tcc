<?php

namespace App\Http\Controllers\Api;

use App\Models\Clients;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardRequest;

class DashboardController extends Controller
{
    public function show(DashboardRequest $request): JsonResponse
    {
        $totalCustomers = Clients::count();
        $totalEarnings = Payment::where('paymentDate', '>=', now()->subDays(30))->sum('totalValue');
        $newServices = Service::where('dateExecution', '>=', now()->subDays(30))->count();
        $expiredServices = Service::where('expired', 3)->count();

        return response()->json([
            'totalCustomers' => $totalCustomers,
            'totalEarnings' => $totalEarnings,
            'newServices' => $newServices,
            'expiredServices' => $expiredServices,
        ]);
    }
}
