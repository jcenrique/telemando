<?php

namespace Database\Seeders;

use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $csvData = fopen(base_path('database/csv/UBICACIONES.csv'), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ';')) !== false) {
            if (!$transRow) {
                Ubicacion::create([
                    'zona_id' => $data['0'],
                    'ubicacion' => $data['1'],
                    'comentario' => $data['2']
                  
                ]);
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
