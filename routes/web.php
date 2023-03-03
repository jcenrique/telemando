<?php

use App\Http\Controllers\AlarmaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuministrosController;
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



Route::get(
    'search',
    [SearchController::class,'index']
)->name('search');

Route::get('suministros/export/', [SuministrosController::class, 'export'])->name('suministros.export');

Route::get('suministros/import/', [SuministrosController::class, 'import'])->name('suministros.import');


Route::get('suministros', [InicioController::class, 'suministros'])->name('suministros');
Route::get('alarmas', [InicioController::class, 'alarmas'])->name('alarmas');

Route::get('alarmas-pruebas', [InicioController::class, 'alarmaspruebas'])->name('alarmas-pruebas');