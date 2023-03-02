<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Detalletecnologia;
use App\Models\Marcavehiculo;
use App\Models\Modelovehiculo;
use App\Models\Tecnologia;
use App\Models\Tipo;
use App\Models\Tipovehiculo;
use App\Models\Vehiculo;
use Carbon\Carbon;

use Illuminate\Database\Seeder;

class VehiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvData = fopen(base_path('database/csv/VEHICULOS.csv'), 'r');
       
        $i=0;
        while (($data = fgetcsv($csvData, 555, ';')) !== false) {
           var_dump($i++ . ' - '   . $data['6']);
          
                Vehiculo::create([
                    'matricula' => $data['0'],
                    'tipovehiculo_id' =>  Tipovehiculo::where('tipo',$data['1'])->first()->id,
                    'marcavehiculo_id' => Marcavehiculo::where('marca',$data['2'])->first()->id,
                    'modelovehiculo_id' =>Modelovehiculo::where('modelo',$data['3'])->first()->id,
                    'departamento_id' => Departamento::where('departamento',$data['4'])->first()->id,
                    'tecnologia_id' => Tecnologia::where('tecnologia',$data['5'])->first()->id,
                    'detalletecnologia_id' =>$data['6']!=' ' ? Detalletecnologia::where('detalle',$data['6'])->first()->id: null,
                    'kilometraje_inicial' => $data['7'],
                    'fecha_matriculacion' => Carbon::parse( str_replace('/' , '-',  $data['8'])),
                    'observacion' => $data['9'],
                    'regimen' => $data['10'],
                    'fecha_baja' => null,
                    'created_at' => Carbon::parse(str_replace('/' , '-',  $data['12'])),
                    'updated_at' => Carbon::parse(str_replace('/' , '-', $data['13'])),


                  
                ]);
           
           
        }
        fclose($csvData);
    }
}
