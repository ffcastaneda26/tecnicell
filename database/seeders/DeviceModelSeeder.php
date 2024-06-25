<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->command->warn('Creando Modelos');

        $sql="INSERT INTO device_models VALUES
            (1, 1, 'Iphone 6x', NULL),
            (2, 3, 'MIT9', NULL),
            (3, 2, 'G125', NULL);";
        DB::update($sql);

        $this->command->info('Modelos Creados');

    }
}
