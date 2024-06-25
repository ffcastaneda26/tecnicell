<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn('Creando Tablas');

        $sql="INSERT INTO brands VALUES
            (1, 'Apple',null),
            (2, 'Samsung',null),
            (3, 'Xiomi',null),
            (4, 'Oppo',null),
            (5, 'Motorola',null),
            (6, 'Huawei',null),
            (7, '360',null),
            (8, 'Acer',null);";
        DB::update($sql);

       $this->command->info('Tablas Creadas');






    }
}
