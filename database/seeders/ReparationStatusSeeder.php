<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReparationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reparation_statuses')->truncate();
        $this->command->warn('Creando Estados de Reparaciones');

        $sql="INSERT INTO reparation_statuses VALUES
            (1, 'Pendiente','Pending'),
            (2, 'Terminado','Finished');";
        DB::update($sql);

       $this->command->info('Estados de Reparaciones Creados');
    }
}
