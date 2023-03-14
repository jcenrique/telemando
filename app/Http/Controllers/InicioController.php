<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class InicioController extends Controller
{
    
    public function alarmas(){

        return view('alarmas');
    }

    public function suministros()
    {
        return view('suministros');
    }


    public function alarmaspruebas()
    {
        return view('alarmas-pruebas');
    }
//     public function swap($lang)
//     {
//         App::setLocale($lang); 
//         // Almacenar el lenguaje en la session
//         session()->put('locale', $lang);
//         return redirect()->back();
//     }
// }
}