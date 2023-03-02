<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
