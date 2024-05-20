<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Service;
use Illuminate\Console\Command;

class FillUnpaindServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataprag:fill-unpaid-services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select all unpaid server and create a new payment for them';

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
        $services = Service::where('payments_id', null)->count();

        $this->confirm("Foram encontrados {$services} serviços sem pagamentos cadastrados. Deseja continuar?");

        $services = Service::where('payments_id', null)->get();

        foreach ($services as $service) {
            $paymentId = Payment::create([
                'clients_id' => $service->clients_id,
                'description' => 'Gerado automaticamente pelo administrador do sistema',
                'paymentMethod' => 'money',
                'paymentDate' => $service->dateExecution,
                'totalValue' => $service->value,
            ]);

            $this->info("Pagamento {$paymentId->id} criado para o serviço {$service->id}");

            $service->payments_id = $paymentId->id;
            $service->save();

            $this->info("Serviço {$service->id} atualizado com o pagamento {$paymentId->id}");
        }

        $this->info("Todos os serviços foram atualizados com sucesso!");

        return Command::SUCCESS;
    }
}
