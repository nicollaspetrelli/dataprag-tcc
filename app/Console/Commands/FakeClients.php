<?php

namespace App\Console\Commands;

use Database\Seeders\ClientSeeder;
use Illuminate\Console\Command;

class FakeClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataprag:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed clients database with fake registers';

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
        (new ClientSeeder())->run();
        $this->info("[DataPrag] Clientes gerados com sucesso!");
        return 0;
    }
}
