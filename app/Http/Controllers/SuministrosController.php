<?php

namespace App\Http\Controllers;

use App\Exports\SuministrosExport;
use App\Models\Suministro;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SuministrosController extends Controller
{
      public function export() 
    {
         
    $date= Suministro::get('updated_at')->sortByDesc('updated_at')->first()->updated_at;
    $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)
                                    ->format('Ymd H,i');

        return Excel::download(new SuministrosExport, $newDate . '_suministros.xlsx');
    }
}
