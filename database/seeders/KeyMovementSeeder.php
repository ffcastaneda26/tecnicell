<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->command->warn('Creando Claves de Movimiento');


        DB::table('key_movements')->truncate();

        $sql= "INSERT INTO key_movements VALUES
        (1,1,'Compra','Comp','Buy','Buy','I','I'),
        (2,1,'Devolución Cliente','DevCte','Customer Return','CusRet','I','I'),
        (3,1,'Ajuste','Ajuste','Adjustment','Adjust','I','I'),
        (4,1,'Venta','Venta','Sale','Sale','I','O'),
        (5,1,'Devolución Proveedor','DevPro','Return to provider','RetPro','I','O'),
        (6,1,'Ajuste','Ajuste','Adjustment','Adjust','I','O');";

        DB::update($sql);

        $this->command->info('Claves de Movimiento Creadas');
    }
}
