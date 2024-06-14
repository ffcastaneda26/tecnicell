<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegimenFiscalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regimenes_fiscales')->truncate();
        $sql="INSERT INTO regimenes_fiscales VALUES
            (1,601,'General de Ley Personas Morales',0,1,'2016-11-12',NULL,1),
            (2,603,'Personas Morales con Fines no Lucrativos',0,1,'2016-11-12',NULL,1),
            (3,605,'Sueldos y Salarios e Ingresos Asimilados a Salarios',1,0,'2016-11-12',NULL,1),
            (4,606,'Arrendamiento',1,0,'2016-11-12',NULL,1),
            (5,608,'Demás ingresos',1,0,'2016-11-12',NULL,1),
            (6,609,'Consolidación',0,1,'2016-11-12','2019-12-31',0),
            (7,610,'Residentes en el Extranjero sin Establecimiento Permanente en México',1,1,'2016-11-12',NULL,1),
            (8,611,'Ingresos por Dividendos (socios y accionistas)',1,0,'2016-11-12',NULL,1),
            (9,612,'Personas Físicas con Actividades Empresariales y Profesionales',1,0,'2016-11-12',NULL,1),
            (10,614,'Ingresos por intereses',1,0,'2016-11-12',NULL,1),
            (11,616,'Sin obligaciones fiscales',1,0,'2016-11-12',NULL,1),
            (12,620,'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',0,1,'2016-11-12',NULL,1),
            (13,621,'Incorporación Fiscal',1,0,'2016-11-12',NULL,1),
            (14,622,'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',1,1,'2016-11-12',NULL,1),
            (15,623,'Opcional para Grupos de Sociedades',0,1,'2016-11-12',NULL,1),
            (16,624,'Coordinados',0,1,'2016-11-12',NULL,1),
            (17,628,'Hidrocarburos',0,1,'2024-01-01',NULL,1),
            (18,607,'Régimen de Enajenación o Adquisición de Bienes',0,1,'2016-11-12',NULL,1),
            (19,629,'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales',1,0,'2024-01-01',NULL,1),
            (20,630,'Enajenación de acciones en bolsa de valores',1,0,'2024-01-01',NULL,1),
            (21,615,'Régimen de los ingresos por obtención de premios',1,0,'2016-11-12',NULL,1),
            (22,625,'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas',1,0,'2020-06-01',NULL,1);";
        DB::update($sql);
    }
}
