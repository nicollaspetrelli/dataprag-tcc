<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Helpers\Docx\DocxMergeHelper;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Docx\DocxRepository;

class GenerateDocsController extends Controller
{
    public function __construct(DocxRepository $docx)
    {
        $this->docx = $docx;
    }

    public function generateWordDocument($serviceId)
    {
        $patch = $this->docx->generateWordDoc($serviceId);
        return response()->download($patch)->deleteFileAfterSend(true);
    }

    public function generatePaymentDoc($paymentId)
    {
        $patch = $this->docx->generatePaymentDoc($paymentId);
        return response()->download($patch)->deleteFileAfterSend(true);
    }

    public function generateMultiplesDocs(Request $request): Response
    {
        $request->validate([
            "services" => "required|array"
        ]);

        $services = $request->input("services");
        $paths = [];

        foreach ($services as $serviceId) {
            $paths[] = $this->docx->generateWordDoc($serviceId);
        }

        $firstService = Service::findOrFail($services[0]);

        $clientName =  str_replace('/', '_', $firstService->clients->companyName);

        $finalPath = storage_path('app/public/' . "Documentos - " . $clientName . ".docx");

        try {
            DocxMergeHelper::merge($paths, $finalPath);
            $randHash = rand(1, 10000000);
            Cache::put($randHash, $finalPath, 120);
        } catch (\Throwable $th) {
            dd($th);
        }

        // remove files from storage
        foreach ($paths as $path) {
            $result = unlink($path);
            Log::info("File removed: " . $path . " - " . $result);
        }

        return response(["cacheId" => $randHash, "path" => $finalPath, "url" => route("download", $randHash)], 200);
    }
}
