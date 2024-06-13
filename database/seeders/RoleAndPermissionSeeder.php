<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->warn(PHP_EOL . ' Creando Permisos');
        // create permissions
        $permissions = [

        ];

        if(count($permissions)){
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
        }
        $this->command->info('Permisos Creados');

        $this->command->info('Creando el rol de Administrador');

        // Admin con todos los permisos
        $role = Role::create(['name' => 'Admin']);
        $this->command->info('Rol de Administrador - Admin - Creado');
        $this->command->info('Creando rol de Suscriptor');
        $role = Role::create(['name' => env('APP_ROLE_TO_SUSCRIPTOR','Suscriptor')]);
        $this->command->info('Rol ' . env('APP_ROL_TO_SUSCRIPTOR','Suscriptor') . ' ha sido creado');
    }
}