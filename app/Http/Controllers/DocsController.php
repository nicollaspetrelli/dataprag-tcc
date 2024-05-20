<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Crypt;

class DocsController extends Controller
{
    public function viewSingleFile($serviceHash)
    {
        $service = Service::where('uuid', $serviceHash)->first();

        if ($service === null) {
            return response()->json([
                'message' => 'Securty token not found',
            ], 404);
        }

        $filePath = storage_path('app/files/') . $service->id . '.pdf';

        if (!file_exists($filePath)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function viewReceiptFile($paymentIdEncoded, $name)
    {
        $paymentId = Crypt::decryptString($paymentIdEncoded);

        $filePath = storage_path('app/files/payments/') . $paymentId . '.pdf';

        if (!file_exists($filePath)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function viewMergedFile($serviceSlug)
    {
        $filePath = storage_path('app/files/merged/') . $serviceSlug . '.pdf';

        if (!file_exists($filePath)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
