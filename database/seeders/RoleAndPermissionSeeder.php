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


        // create permissions
        $permissions = [

        ];

        if(count($permissions)){
            $this->command->warn(PHP_EOL . __('Creating Permissions'));
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
        }
        $this->command->info(__('Permissions Created'));

        $this->command->info(__('Creating Role Admin'));


        // Admin con todos los permisos
        $role = Role::create(['name' => 'Admin']);
        $this->command->info(__('Admin Role Created'));
        $this->command->info(__('Creating Role para Suscriptor'));
        $role = Role::create(['name' => env('APP_ROL_TO_SUSCRIPTOR','Suscriptor')]);
        $this->command->info('Rol ' . env('APP_ROL_TO_SUSCRIPTOR','Suscriptor') . ' ha sido creado');

        $roles = [
            'Vendedor',
            'Técnico',
            'Almacenista'
        ];

        if(count($roles)){
            $this->command->warn(PHP_EOL . ' Creando Roles Adicionales');
            foreach ($roles as $role) {

                $role = Role::create(['name' => $role]);
                $this->command->info(PHP_EOL . ' Rol ' . $role->name . ' Creado');
            }
        }
    }
}
