<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Services\DocumentsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExportPaymentsRequest;
use App\Http\Requests\ExportServicesRequest;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller
{
    public function export(ExportServicesRequest $request): JsonResponse
    {
        $serviceIds = $request->get('services');

        if ($request->hasToPrintPayment()) {
            return $this->multipleDocumentsAndPayments($serviceIds);
        }

        if (count($serviceIds) > 1) {
            return $this->multipleDocuments($serviceIds);
        }

        return $this->singleDocument($serviceIds[0]);
    }

    public function exportPayment(ExportPaymentsRequest $request): JsonResponse
    {
        $paymentId = $request->get('payments');

        $payment = Payment::findOrFail($paymentId);

        $documentsService = new DocumentsService();

        $finalPath = $documentsService->generatePaymentReceiptPath($payment);

        $downloadUrl = $documentsService->generatePaymentReceiptSecretLink($payment);

        if (file_exists($finalPath)) {
            return response()->json([
                'message' => 'Recibo exportado com sucesso (Cache)',
                'link' => $downloadUrl,
            ], Response::HTTP_OK);
        }

        $documentsService->savePaymentReceipt($payment);

        Log::info(
            'Usuario exportou o recibo',
            [
                'userEmail' => auth()->user()->email,
                'paymentId' => $paymentId,
                'downloadUrl' => $downloadUrl,
            ]
        );

        return response()->json([
            'message' => 'Recibo exportado com sucesso',
            'link' => $downloadUrl,
        ], Response::HTTP_OK);
    }

    public function singleDocument(string $serviceId): JsonResponse
    {
        $documentsService = new DocumentsService();

        $documentsService->saveDocument($serviceId);
        $downloadUrl = $documentsService->generateSingleFileSecretLink($serviceId);

        Log::info(
            'Usuario exportou o serviço',
            [
                'userEmail' => auth()->user()->email,
                'serviceId' => $serviceId,
                'downloadUrl' => $downloadUrl,
            ]
        );

        return response()->json([
            'message' => 'Serviço exportado com sucesso',
            'link' => $downloadUrl,
        ], Response::HTTP_OK);
    }

    private function multipleDocuments(array $serviceIds): JsonResponse
    {
        $documentsService = new DocumentsService();

        $finalPath = $documentsService->generateMergedFilesPath($serviceIds);

        if (file_exists($finalPath)) {
            $downloadUrl = $documentsService->generateMergedFileSecretLink($serviceIds);

            return response()->json([
                'message' => 'Serviços exportados com sucesso (Cache)',
                'link' => $downloadUrl,
            ], Response::HTTP_OK);
        }

        foreach ($serviceIds as $serviceId) {
            $documentsService->saveDocument($serviceId);
        }

        $documentsService->mergeDocuments($serviceIds);
        $downloadUrl = $documentsService->generateMergedFileSecretLink($serviceIds);

        Log::info(
            'Usuario exportou os serviços',
            [
                'userEmail' => auth()->user()->email,
                'serviceIds' => $serviceIds,
                'downloadUrl' => $downloadUrl,
            ]
        );

        return response()->json([
            'message' => 'Serviços exportados com sucesso',
            'link' => $downloadUrl,
        ], Response::HTTP_OK);
    }

    private function multipleDocumentsAndPayments(array $serviceIds): JsonResponse
    {
        $documentsService = new DocumentsService();

        $paymentsIds = [];

        foreach ($serviceIds as $serviceId) {
            $service = Service::findOrFail($serviceId);
            $paymentsIds[] = $service->payments_id;

            $documentsService->saveDocument($serviceId);
        }

        $paymentsIds = array_unique($paymentsIds);
        foreach ($paymentsIds as $paymentId) {
            $payment = Payment::findOrFail($paymentId);
            $documentsService->savePaymentReceipt($payment);
        }

        $finalPath = $documentsService->generateMergedFilesPath($serviceIds, $paymentsIds);

        if (file_exists($finalPath)) {
            $downloadUrl = $documentsService->generateMergedFileSecretLink($serviceIds, $paymentsIds);

            return response()->json([
                'message' => 'Serviços exportados com sucesso (Cache)',
                'link' => $downloadUrl,
            ], Response::HTTP_OK);
        }

        $documentsService->mergeDocuments($serviceIds, $paymentsIds);
        $downloadUrl = $documentsService->generateMergedFileSecretLink($serviceIds, $paymentsIds);

        Log::info(
            'Usuario exportou os serviços',
            [
                'userEmail' => auth()->user()->email,
                'serviceIds' => $serviceIds,
                'downloadUrl' => $downloadUrl,
            ]
        );

        return response()->json([
            'message' => 'Serviços exportados com sucesso',
            'link' => $downloadUrl,
        ], Response::HTTP_OK);
    }
}
