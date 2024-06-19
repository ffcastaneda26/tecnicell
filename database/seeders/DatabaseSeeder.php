<?php

namespace Database\Seeders;

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
            'companies',
        ]);

        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserAdminTableSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(RegimenFiscalSeeder::class);
        $this->call(CompanySeeder::class);
    }

    protected function truncateTables(array $tables) {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Desactivamos la revisión de claves foráneas
    }
}
