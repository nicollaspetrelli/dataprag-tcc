<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('doc/{serviceId}/{name}', 'App\Http\Controllers\DocsController@viewSingleFile');
Route::get('docs/{serviceSlug}/{name}', 'App\Http\Controllers\DocsController@viewMergedFile');
Route::get('receipt/{paymentIdEncoded}/{name}', 'App\Http\Controllers\DocsController@viewReceiptFile');

Route::get('certificates/{serviceHash}', 'App\Http\Controllers\CertificateController@show')->name('certificates');

// Grupo de Middleware Auth
Route::middleware(['auth'])->group(function () {

    // Página Princial
    Route::permanentRedirect('/', '/painel');

    // Route to show php ini
    Route::get('phpinfo', function () {
        phpinfo();
    });

    Route::get('documents/{cacheId}/{name}', 'App\Http\Controllers\DocumentsController@stream')->name('show.document');

    // Dashboard Controller
    Route::get('/painel', 'App\Http\Controllers\DashboardController@index')->name('painel');

    // Clientes
    Route::resource('clientes', 'App\Http\Controllers\ClientController');
    Route::post('/clients/getClients/', 'App\Http\Controllers\ClientController@getClients')->name('clients.getClients');
    Route::get('/clients/dt/', 'App\Http\Controllers\ClientController@clientsDt')->name('clients.dt');

    // Serviços
    Route::resource('services', 'App\Http\Controllers\ServiceController');

    // Products
    Route::resource('products', 'App\Http\Controllers\ProductsController');

    Route::get('novoservico', function () {
        return view('pages.services.select');
    })->name('services.select');

    Route::get('novoservico/{clientId}', 'App\Http\Controllers\ServiceController@createByClient')->name('services.newByClient');
    Route::post('/servicos/getServices', 'App\Http\Controllers\ServiceController@getServices')->name('services.getServices');

    Route::post('/servicos/imprimir', 'App\Http\Controllers\DocumentsController@generateMultipleDocuments')->name('services.print');
    Route::post('/servicos/imprimir/docx', 'App\Http\Controllers\GenerateDocsController@generateMultiplesDocs')->name('services.printx');

    // Declarações
    Route::get('declaracoes', 'App\Http\Controllers\DeclarationController@create')->name('declarations.create');
    Route::post('declaracoes/gerar', 'App\Http\Controllers\DeclarationController@generate')->name('declarations.generate');

    // Payments
    Route::get('payments', 'App\Http\Controllers\PaymentController@index')->name('payments.index');

    Route::post('payment/generate', 'App\Http\Controllers\PaymentController@generatePayment')->name('payment.generate');
    Route::delete('payment/{paymentId}', 'App\Http\Controllers\PaymentController@destroy')->name('payment.destroy');

    Route::get('payments/doc/{paymentId}', 'App\Http\Controllers\DocumentsController@generatePaymentDocument')->name('payments.doc');
    Route::get('payments/docx/{paymentId}', 'App\Http\Controllers\GenerateDocsController@generatePaymentDoc')->name('payments.docx');

    // Verifica o vencimento do Cliente
    Route::get('verificar/{clientId}', 'App\Http\Controllers\ClientController@isOverdue');

    // Documents

    Route::get('documents/all', 'App\Http\Controllers\DocumentsController@getAll')->name('documents.getAll');


    // Dashboard
    Route::get('/dashboard/revenue', 'App\Http\Controllers\DashboardController@calculateRevenue')->name('dashboard.revenue');
    Route::get('/dashboard/services', 'App\Http\Controllers\DashboardController@calculateTypesOfServices')->name('dashboard.services');

    Route::get('/doc/{serviceId}', 'App\Http\Controllers\DocumentsController@generateDocument')->name('docs.services');

    Route::get('/docx/{serviceId}', 'App\Http\Controllers\GenerateDocsController@generateWordDocument')->name('docx.services');

    Route::get('api', function () {
        return "ok!";
    });
});
