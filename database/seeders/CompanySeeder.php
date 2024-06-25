<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn('Creando Empresas');


        DB::table('company_user')->truncate();
        DB::table('companies')->truncate();


        Company::factory(2)->create();

        $this->command->info('Empresas Creadas');


        $this->command->warn('Asignando Empresa a Usuarios con Rol Gerente');

        // Gerente para empresa 1
        $company= Company::findOrFail(1);
        $user= User::where('email','gerente@empresa1.com')->first();
        $user->companies()->sync($company->id);

        // Gerente para empresa 2
        $company= Company::findOrFail(2);
        $user= User::where('email','gerente@empresa2.com')->first();
        $user->companies()->sync($company->id);

        $this->command->info('Empresas Asignadas a Usuarios con Rol Gerente');

    }
}
