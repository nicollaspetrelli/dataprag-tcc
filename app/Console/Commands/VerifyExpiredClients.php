<?php

namespace App\Console\Commands;

use App\Helpers\Service\ServiceHelper;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class VerifyExpiredClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataprag:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run verification clients/service expiration date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("[DataPrag] Running customer expired validation - " . Carbon::now('America/Sao_Paulo'));

        $clients = Clients::all();

        foreach ($clients as $client) {
            $services = $client->service()->whereNull('deleted_at')->get();

            foreach ($services as $service) {
                ServiceHelper::verifyService($service);
            }
        }

        Log::info("[DataPrag] Finished customer validation service - " . Carbon::now('America/Sao_Paulo'));

        return 0;
    }
}
