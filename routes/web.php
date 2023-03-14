<?php

use App\Http\Controllers\AlarmaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuministrosController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('home');
})->name('inicio');

Route::get('lang}', function($lang = null){
   $lang = Auth::user()->lang;
    App::setLocale($lang); 
    session()->put('lang', $lang);
    return redirect()->back();
})->name('lang.swap');
//Route::get('lang/{lang?}', [InicioController::class,'swap'])->name('lang.swap');
Route::get(
    'search',
    [SearchController::class,'index']
)->name('search');

Route::get('suministros/export/', [SuministrosController::class, 'export'])->name('suministros.export');

Route::get('suministros/exportvehiculo', [SuministrosController::class, 'exportVehiculo'])->name('suministros.exportVehiculo');




Route::get('suministros', [InicioController::class, 'suministros'])->name('suministros');
Route::get('alarmas', [InicioController::class, 'alarmas'])->name('alarmas');

Route::get('alarmas-pruebas', [InicioController::class, 'alarmaspruebas'])->name('alarmas-pruebas');