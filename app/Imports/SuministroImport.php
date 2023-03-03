<?php

namespace App\Imports;

use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Zona;
use Illuminate\Support\Collection;
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
            $medida =  $row[15];
        }else{
            $medida =NULL;
        }
        if( $row[17]!= null){
            $icp =  $row[17];
        }else{
            $icp =NULL;
        }
        if( $row[18]!= null){
            $contador =  $row[18];
        }else{
            $contador =NULL;
        }
       
        if( Zona::where('zona' , $row[3])->first()){
            $zona_id =  Zona::where('zona' , $row[3])->first()->id;
        }else{
            $zona_id =4;
        }
        if( Tarifa::where('tarifa', $row[4])->first()){
            $tarifa_id =  Tarifa::where('tarifa', $row[4])->first()->id;
        }else{
            $tarifa_id =6;
        }
        
        return new Suministro ([
            'direccion' => $row[0],
            'CUP' =>  mb_strtoupper($row[1]),
            'poblacion' => mb_strtoupper($row[2]),
            'zona_id' =>$zona_id ,
            'tarifa_id' =>$tarifa_id , 
            'P1' =>  mb_strtoupper($row[5]),
            'P2' =>  mb_strtoupper($row[6]),
            'P3' =>  mb_strtoupper($row[7]),
            'P4' =>  mb_strtoupper($row[8]),
            'P5' =>  mb_strtoupper($row[9]),
            'P6' =>  mb_strtoupper($row[10]),
            
            'tension_id' => $tension_id,
            'contrato' => $row[12],
            'instalacion' =>  mb_strtoupper($row[13]),
            'num_contador' =>  mb_strtoupper($row[14]),
            'medida' => $medida,
            'relacion_id' => $relacion_id,
            'icp' => $icp,
            'contador' => $contador



        ]);
        
	}

    public function onFailure(Failure ...$failures)
    {
        
    }
}
