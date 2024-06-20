<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $company= Company::findOrFail(1);
        $user = User::role('Gerente')->where('active',1)->first();
        Client::factory(20)->create([
            'company_id'=> $company->id,
            'user_id'   => $user->id,
        ]);
    }
}
