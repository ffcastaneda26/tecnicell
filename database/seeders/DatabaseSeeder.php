<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->warn(PHP_EOL . __('Truncando Tablas'));
        $this->truncateTables([
            'user_roles',
            'role_permissions',
            'user_permissions',
            'users',
            'roles',
            'permissions',
            'states',
            'countries',
            'regimenes_fiscales',
            'device_types',
            'device_statuses',
            'cotization_statuses',
            'reparation_statuses',
            'brands',
            'device_models',
            'company_user',
            'companies',
            'branches',
            'clients'
        ]);
        $this->command->info('Talas Trucadas');

        $this->call([
            RoleAndPermissionSeeder::class,
            UserAdminTableSeeder::class,
            CountrySeeder::class,
            StatesSeeder::class,
            RegimenFiscalSeeder::class,
            DeviceTypeSeeder::class,
            DeviceStatusSeeder::class,
            CotizationStatusSeeder::class,
            ReparationStatusSeeder::class,
            BrandSeeder::class,
            DeviceModelSeeder::class,
            CompanySeeder::class,
            BranchSeeder::class,
            ClientSeeder::class,
        ]);


    }

    protected function truncateTables(array $tables) {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Desactivamos la revisión de claves foráneas
    }
}
