<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class DownloadController extends Controller
{
    public function download($cacheId)
    {
        $filePath = Cache::get($cacheId);
        return response()->download($filePath);
    }
}
