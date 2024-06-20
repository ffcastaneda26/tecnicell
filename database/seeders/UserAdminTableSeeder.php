<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn(PHP_EOL . __('Creando') . ' ' . __('General Administrator') . ' ' .  __('User'));

        User::create([
            "name"      => "Administrador General",
            "email"     => "admin@tecnicell.com",
            "password"  => bcrypt("admintecnicell"),
            "active"    => 1
        ])->assignRole('Admin');

        $this->command->info('Usuario administrador general creado');

        $this->command->warn('Creando usuario Gerente');
        $this->command->warn(PHP_EOL . __('Creando') . ' ' . __('Manager User'));


        User::create([
            "name"      => "Gerente Empresa Pruebas",
            "email"     => "gerente@tecnicell.com",
            "password"  => bcrypt("password"),
            "active"    => 1
        ])->assignRole(env('APP_ROL_TO_SUSCRIPTOR',__('Manager User')));
        $this->command->info('Usuario Gerente creado');

    }
}
