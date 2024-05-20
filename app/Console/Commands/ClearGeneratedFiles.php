<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearGeneratedFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataprag:clearCache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpa o Cache de arquivos .pdf gerados';

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
        $this->info("[Command] Limpando arquivos gerados...");

        $files = glob(storage_path('app/files/*.pdf'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $this->info("[Command] Arquivos gerados removidos!");

        $files = glob(storage_path('app/files/merged/*.pdf'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $this->info("[Command] Arquivos gerados merged removidos!");

        $files = glob(storage_path('app/files/payments/*.pdf'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $this->info("[Command] Arquivos gerados payments removidos!");

        return Command::SUCCESS;
    }
}
