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
        User::create([
            "name"      => "Administrador General",
            "email"     => "admin@tecnicell.com",
            "password"  => bcrypt("admintecnicell"),
            "active"    => 1
        ])->assignRole('Admin');

    }
}
