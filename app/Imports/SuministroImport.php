<?php

namespace App\Imports;

use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Zona;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;

class SuministroImport implements ToModel, SkipsEmptyRows,SkipsOnFailure
{
   
    use RemembersRowNumber,SkipsFailures;
 

	public function model(array $row) {
        if($this->getRowNumber()==1) return; 
       //buscar suministro duplicado
       $value_CUP=trim(mb_strtoupper($row[1]));
        $cup = Suministro::where('CUP', $value_CUP)->first();
        
        if(!is_null($cup)){
            Log::channel('db')->info('Suministro duplicado ' . trim(mb_strtoupper($row[1]) . ', en la fila ' .$this->getRowNumber()));
            return;
        }

        if( Tension::where('tension' ,$row[11])->first()){
            $tension_id =  Tension::where('tension' ,$row[11])->first()->id;
        }else{
            $tension_id =NULL;
        }
        if( Relacion::where('relacion', $row[16])->first()){
            $relacion_id =  Relacion::where('relacion', $row[16])->first()->id;
        }else{
            $relacion_id =NULL;
        }
        if( $row[15]!= null){
            $medida =  trim($row[15]);
        }else{
            $medida =NULL;
        }
        if( $row[18]!= null){
            $icp =  trim($row[18]);
        }else{
            $icp =NULL;
        }
        if( $row[19]!= null){
            $contador =  trim($row[19]);
        }else{
            $contador =NULL;
        }
       
        if( Zona::where('zona' , $row[3])->first()){
            $zona_id =  Zona::where('zona' , trim(mb_strtoupper($row[3])))->first()->id;
        }else{
            $zona_id =4;
        }
        if( Tarifa::where('tarifa', $row[4])->first()){
            $tarifa_id =  Tarifa::where('tarifa', $row[4])->first()->id;
        }else{
            $tarifa_id =6;
        }
        
        return new Suministro ([
           
            'direccion' =>trim($row[0]),
            'CUP' =>  trim(mb_strtoupper($row[1])),
            'poblacion' => trim(mb_strtoupper($row[2])),
            'zona_id' =>$zona_id ,
            'tarifa_id' =>$tarifa_id , 
            'P1' =>  trim(mb_strtoupper($row[5])),
            'P2' =>  trim(mb_strtoupper($row[6])),
            'P3' =>  trim(mb_strtoupper($row[7])),
            'P4' =>  trim(mb_strtoupper($row[8])),
            'P5' =>  trim(mb_strtoupper($row[9])),
            'P6' =>  trim(mb_strtoupper($row[10])),
            
            'tension_id' => $tension_id,
            'contrato' => $row[12],
            'instalacion' =>  trim(mb_strtoupper($row[13])),
            'num_contador' =>  trim(mb_strtoupper($row[14])),
            'medida' => $medida,
            'relacion_id' => $relacion_id,
            'icp' => $icp,
            'contador' => $contador,
            'telegestion' =>trim( mb_strtoupper($row[17]))=='NO' ?0 :1,
            'comercializadora' => trim(mb_strtoupper($row[20])),
            'observacion' => trim(mb_strtoupper($row[21])),

        ]);
        
	}

    public function onFailure(Failure ...$failures)
    {
        
    }
}
