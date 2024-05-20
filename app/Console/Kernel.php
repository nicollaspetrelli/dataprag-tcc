<?php

namespace App\Console;

use App\Services\Notification\DiscordWebhook;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $notification = new DiscordWebhook();

        $schedule->command('dataprag:verify')->dailyAt('01:00')->onSuccess(function (Stringable $output) use ($notification) {
            $notification->send(theme: 'success', body: 'Verificação de clientes e serviços expirados executada com sucesso!');
        })->onFailure(function (Stringable $output) use ($notification) {
            Log::error($output);
            $notification->send(theme: 'error', body: 'Verificação de clientes e serviços expirados falhou!');
        });

        $schedule->command('dataprag:clearCache')->weekly()->onSuccess(function (Stringable $output) use ($notification) {
            $notification->send(theme: 'success', body: 'Limpeza de arquivos gerados executada com sucesso!');
        })->onFailure(function (Stringable $output) use ($notification) {
            Log::error($output);
            $notification->send(theme: 'error', body: 'Limpeza de arquivos gerados falhou!');
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
