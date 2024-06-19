<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(2)->create();
        $company= Company::findOrFail(1);

        $user= User::where('email','gerente@tecnicell.com')->first();
        $user->companies()->sync($company->id);
    }
}
