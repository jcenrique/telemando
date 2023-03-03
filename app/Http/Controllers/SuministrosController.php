<?php

namespace App\Http\Controllers;

use App\Exports\SuministrosExport;
use App\Imports\RepostajesImport;
use App\Models\Suministro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Support\Facades\Toast;

class SuministrosController extends Controller
{
      public function export() 
    {
         
    $date= Suministro::get('updated_at')->sortByDesc('updated_at')->first()->updated_at;
    $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)
                                    ->format('Ymd H,i');

        return Excel::download(new SuministrosExport, $newDate . '_suministros.xlsx');
    }


    public function import() 
    {
      
      $filePath = 'Operaciones reducidas2.xlsx';
       
        //borrar todos los emenetos y alarmas en cascada de la ubicacion elegida y equipo elegido
     

        //leer las hojas y crear lon nuevos elementos en la DB 


           
            $importHoja = new RepostajesImport();

           
            Excel::import($importHoja, $filePath);
        

            foreach ($importHoja->failures() as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
           }





        Toast::info(__('Alarmas importadas a la DB!.'));
    }
}
