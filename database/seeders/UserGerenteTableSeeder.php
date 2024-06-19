<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserGerenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            "name"      => "Gerente Empresa Pruebas",
            "email"     => "gerente@tecnicell.com",
            "password"  => bcrypt("password"),
            "active"    => 1
        ])->assignRole(env('APP_ROL_TO_SUSCRIPTOR','Gerente'));


    }
}
