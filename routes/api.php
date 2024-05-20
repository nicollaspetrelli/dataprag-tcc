<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/healthcheck', function () {
    Log::info('healthcheck accessed', ['ip' => request()->ip(), 'user_agent' => request()->userAgent()]);
    return response()->json(['message' => 'Dataprag API is running!']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/cnpj/{cnpj}', [App\Http\Controllers\Api\SearchCNPJ::class, 'search']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/me', function (Request $request) {
        return auth()->user();
    });
    Route::get('/customers', [App\Http\Controllers\Api\CustomerController::class, 'all']);
    Route::get('/customer/{id}', [App\Http\Controllers\Api\CustomerController::class, 'show']);

    Route::post('/customer', [App\Http\Controllers\Api\CustomerController::class, 'store']);
    Route::put('/customer/{id}', [App\Http\Controllers\Api\CustomerController::class, 'update']);
    Route::delete('/customer/{id}', [App\Http\Controllers\Api\CustomerController::class, 'delete']);

    Route::get('/customer/{customerId}/services', [App\Http\Controllers\Api\ServiceController::class, 'find']);

    Route::get('/dashboard', [App\Http\Controllers\Api\DashboardController::class, 'show']);

    Route::group(['prefix' => 'service'], function () {
        Route::get('/export', [App\Http\Controllers\Api\ExportController::class, 'export']);
        Route::get('/{customerId}/unpaid', [App\Http\Controllers\Api\ServiceController::class, 'unpaid']);
        Route::get('/', [App\Http\Controllers\Api\ServiceController::class, 'all']);
        Route::get('/expired', [App\Http\Controllers\Api\ServiceController::class, 'expired']);
        Route::get('/{id}', [App\Http\Controllers\Api\ServiceController::class, 'show']);
        Route::post('/', [App\Http\Controllers\Api\ServiceController::class, 'store']);
        Route::put('/{id}', [App\Http\Controllers\Api\ServiceController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Api\ServiceController::class, 'delete']);
    });

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/export', [App\Http\Controllers\Api\ExportController::class, 'exportPayment']);
        // TODO: Route::get('/', [App\Http\Controllers\Api\PaymentController::class, 'all']);
        // TODO: Route::get('/{id}', [App\Http\Controllers\Api\PaymentController::class, 'show']);
        Route::post('/', [PaymentController::class, 'store']);
        // TODO: Route::put('/{id}', [App\Http\Controllers\Api\PaymentController::class, 'update']);
        // TODO: Route::delete('/{id}', [App\Http\Controllers\Api\PaymentController::class, 'delete']);
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [App\Http\Controllers\Api\ProductsController::class, 'all']);
        Route::get('/{id}', [App\Http\Controllers\Api\ProductsController::class, 'show']);
        Route::post('/', [App\Http\Controllers\Api\ProductsController::class, 'store']);
        Route::put('/{id}', [App\Http\Controllers\Api\ProductsController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\Api\ProductsController::class, 'delete']);
    });

    Route::get('/handout', [App\Http\Controllers\Api\HandoutController::class, 'show']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
