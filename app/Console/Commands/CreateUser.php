<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {name? : User name} {email? : User email} {pass? : Password} {picture? : Profile pic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user to Database';

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
        $name = $this->argument('name');
        $email = $this->argument('email');
        $pass = $this->argument('pass');
        $picture = $this->argument('picture');

        if (($name || $email || $pass || $picture) == null) {
            $this->info("Sem argumentos");
            return 0;
        }

        $this->createUserByArguments($name, $email, $pass, $picture);
    }

    private function createUserByArguments(string $name, string $email, string $pass, string $picture)
    {
        $this->info("[DataPrag] Nome: $name");
        $this->info("[DataPrag] Email: $email");
        $this->info("[DataPrag] Senha: $pass");
        $this->info("[DataPrag] Picture: $picture");

        if ($picture == "default") {
            $nameArray = explode(' ', $name);
            $initials = strtoupper(substr($nameArray[0], 0, 1) . substr(end($nameArray), 0, 1));
            $this->info("[DataPrag] Iniciais do nome: $initials");

            $picture = "https://ui-avatars.com/api/?name=" . $initials . "&background=38a169&rounded=true&color=e5e7eb";
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($pass);
        $user->picture = $picture;

        $result = $user->save();
        $id = $user->id;

        $this->info("[DataPrag] Usuario criado com sucesso! ID: $id");
        return 0;
    }
}
