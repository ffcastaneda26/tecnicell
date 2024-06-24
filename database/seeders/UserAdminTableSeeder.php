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

        $this->command->info('Usuario administrador Geberak');

        $this->command->warn('Creando usuarios  con rol de Gerente');


        $this->command->warn(PHP_EOL . ' Creando Gerente 1');
        User::create([
            "name"      => "Gerente Empresa 1",
            "email"     => "gerente@empresa1.com",
            "password"  => bcrypt("password")
        ])->assignRole(env('APP_ROL_TO_SUSCRIPTOR',__('Manager User')));

        $this->command->info('Gerente1 creado');

        $this->command->warn(PHP_EOL . ' Creando Gerente 2');
        User::create([
            "name"      => "Gerente Empresa 2",
            "email"     => "gerente@empresa2.com",
            "password"  => bcrypt("password")
        ])->assignRole(env('APP_ROL_TO_SUSCRIPTOR',__('Manager User')));

        $this->command->info('Gerente1 creado');

    }
}
