<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('device_types')->truncate();
        $this->command->warn('Creando Tipos de Dispositivo');
        DeviceType::create([
            'spanish' => 'Celular',
            'english' => 'Cellphone'
        ]);
        DeviceType::create([
            'spanish' => 'Laptop',
            'english' => 'Laptop'
        ]);

        DeviceType::create([
            'spanish' => 'Celular Inteligente',
            'english' => 'Smart Phone'
        ]);

        DeviceType::create([
            'spanish' => 'Tableta',
            'english' => 'Tablet'
        ]);
        
        $this->command->info('Tipos de Dispositivo Creados');


    }
}
