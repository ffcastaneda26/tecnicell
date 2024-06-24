<?php

namespace Database\Seeders;

use App\Models\DeviceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('device_statuses')->truncate();
        $this->command->warn('Creando Estados de Dispositivo');
        DeviceStatus::create([
            'spanish' => 'Activo',
            'english' => 'Active'
        ]);
        DeviceStatus::create([
            'spanish' => 'Dañado',
            'english' => 'Damage'
        ]);


        $this->command->info('Estados de Dispositivo Creados');
    }
}
