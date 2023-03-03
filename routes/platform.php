<?php

declare(strict_types=1);


use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Suministros\SuministroEditScreen;
use App\Orchid\Screens\Suministros\SuministroListScreen;
use App\Orchid\Screens\Telemando\ElementoEditScreen;
use App\Orchid\Screens\Telemando\UbicacionEditScreen;
use App\Orchid\Screens\Telemando\UbicacionListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Vehiculos\DetalleTecnologiaVehiculosEdiScreen;
use App\Orchid\Screens\Vehiculos\DetalleTecnologiaVehiculosListScreen;
use App\Orchid\Screens\Vehiculos\KilometrosVehiculosEditScreen;
use App\Orchid\Screens\Vehiculos\KilometrosVehiculosScreen;
use App\Orchid\Screens\Vehiculos\MarcaVehiculoEditScreen;
use App\Orchid\Screens\Vehiculos\MarcaVehiculoListScreen;
use App\Orchid\Screens\Vehiculos\ModeloVehiculoEditScreen;
use App\Orchid\Screens\Vehiculos\ModeloVehiculoListScreen;
use App\Orchid\Screens\Vehiculos\TecnologiaVehiculosEdiScreen;
use App\Orchid\Screens\Vehiculos\TecnologiaVehiculosListScreen;
use App\Orchid\Screens\Vehiculos\TipoVehiculoEditScreen;
use App\Orchid\Screens\Vehiculos\VehiculoEditScreen;
use App\Orchid\Screens\Vehiculos\VehiculoListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\Vehiculos\TipoVehiculoListScreen;
use App\Orchid\Screens\Vehiculos\RespostajesVehiculosScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push(__('User'), route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Role'), route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
// Route::screen('example', ExampleScreen::class)
//     ->name('platform.example')
//     ->breadcrumbs(fn (Trail $trail) => $trail
//         ->parent('platform.index')
//         ->push('Example screen'));

// Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
// Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
// Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
// Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
// Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
// Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', Idea::class, 'platform.screens.idea');



Route::screen('elementos/{ubicacion?}', ElementoEditScreen::class)->name('platform.elementos.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ubicaciones')
            ->push(__('Añadir Elementos'), route('platform.ubicaciones'));
    });

Route::screen('elemento/{elemento}/editar', ElementoEditScreen::class)->name('platform.elemento.editar')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ubicaciones')
            ->push(__('Añadir Elementos'), route('platform.ubicaciones'));
    });
Route::screen('elementos/{elemento}/delete', ElementoEditScreen::class)->name('platform.elemento.delete')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ubicaciones')
            ->push(__('Añadir Elementos'), route('platform.ubicaciones'));
    });



Route::screen('ubicacion/{ubicacion?}', UbicacionEditScreen::class)->name('platform.ubicacion.edit')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ubicaciones')
            ->push(__('Editar Ubicación'), route('platform.ubicaciones'));
    });
Route::screen('ubicacion/nuevo/create', UbicacionEditScreen::class)->name('platform.ubicacion.nuevo.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.ubicaciones')
            ->push(__('Añadir Ubicación'), route('platform.ubicaciones'));
    });

Route::screen('ubicaciones', UbicacionListScreen::class)->name('platform.ubicaciones')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Ubicaciones'), route('platform.ubicaciones'));
    });


// rutas suministros


Route::screen('suministros/create', SuministroEditScreen::class)->name('platform.suministro.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Añadir Suministro'), route('platform.suministros'));
    });

Route::screen('suministros/{suministro?}/edit', SuministroEditScreen::class)
    ->name('platform.suministro.edit')
    ->breadcrumbs(fn (Trail $trail, $suministro) => $trail
        ->parent('platform.suministros')
        ->push(__('Editar Suministro'), route('platform.suministro.edit', $suministro)));


Route::screen('suministros', SuministroListScreen::class)
    ->name('platform.suministros')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.index')
        ->push(__('Suministros'), route('platform.suministros')));


//Vehiculos

// vehiculos


Route::screen('vehiculo/create', VehiculoEditScreen::class)->name('platform.vehiculo.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos')
            ->push(__('Añadir Vehiculo'), route('platform.vehiculos'));
    });

Route::screen('vehiculo/{id?}/edit', VehiculoEditScreen::class)
    ->name('platform.vehiculo.edit')
    ->breadcrumbs(fn (Trail $trail, $vehiculo) => $trail
        ->parent('platform.vehiculos')
        ->push(__('Editar Vehiculo'), route('platform.vehiculos')));


Route::screen('vehiculos', VehiculoListScreen::class)
    ->name('platform.vehiculos')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.index')
        ->push(__('Vehiculos'), route('platform.vehiculos')));



//marca       
Route::screen('vehiculos/marca/create', MarcaVehiculoEditScreen::class)->name('platform.vehiculos.marca.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos.marcas')
            ->push(__('Añadir marca vehiculo'), route('platform.vehiculos.marcas'));
    });

Route::screen('vehiculos/marca/{marca?}/edit', MarcaVehiculoEditScreen::class)
    ->name('platform.vehiculos.marca.edit')
    ->breadcrumbs(fn (Trail $trail, $marca) => $trail
        ->parent('platform.vehiculos.marcas')
        ->push(__('Editar marca vehiculo'), route('platform.vehiculos.marcas')));


Route::screen('vehiculos/marcas', MarcaVehiculoListScreen::class)
    ->name('platform.vehiculos.marcas')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Marcas de Vehículos'), route('platform.vehiculos.marcas')));


//modelo
Route::screen('vehiculos/modelo/create', ModeloVehiculoEditScreen::class)->name('platform.vehiculos.modelo.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos.modelos')
            ->push(__('Añadir modelo vehiculo'), route('platform.vehiculos.modelos'));
    });

Route::screen('vehiculos/modelo/{marca?}/edit', ModeloVehiculoEditScreen::class)
    ->name('platform.vehiculos.modelo.edit')
    ->breadcrumbs(fn (Trail $trail, $modelo) => $trail
        ->parent('platform.vehiculos.modelos')
        ->push(__('Editar modelo vehiculo'), route('platform.vehiculos.modelo.edit', $modelo)));


Route::screen('vehiculos/modelos', ModeloVehiculoListScreen::class)
    ->name('platform.vehiculos.modelos')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Modelos de Vehiculos'), route('platform.vehiculos.modelos')));

//tipo vehiculo

Route::screen('vehiculos/tipo/create', TipoVehiculoEditScreen::class)->name('platform.vehiculos.tipo.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos.tipos')
            ->push(__('Añadir tipo vehículo'), route('platform.vehiculos.tipos'));
    });


Route::screen('vehiculos/tipo/{marca?}/edit', TipoVehiculoEditScreen::class)
    ->name('platform.vehiculos.tipo.edit')
    ->breadcrumbs(fn (Trail $trail, $tipo) => $trail
        ->parent('platform.vehiculos.tipos')
        ->push(__('Editar tipo vehiculo'), route('platform.vehiculos.tipos')));


Route::screen('vehiculos/tipos', TipoVehiculoListScreen::class)
    ->name('platform.vehiculos.tipos')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Tipos de Vehiculos'), route('platform.vehiculos.tipos')));


//tecnologia

Route::screen('vehiculos/tecnologia/create', TecnologiaVehiculosEdiScreen::class)->name('platform.vehiculos.tecnologia.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos.tecnologias')
            ->push(__('Añadir tecnología vehículo'), route('platform.vehiculos.tecnologias'));
    });


Route::screen('vehiculos/tecnologia/{tecnologia?}/edit', TecnologiaVehiculosEdiScreen::class)
    ->name('platform.vehiculos.tecnologia.edit')
    ->breadcrumbs(fn (Trail $trail, $tecnologia) => $trail
        ->parent('platform.vehiculos.tecnologias')
        ->push(__('Editar tecnología vehiculo'), route('platform.vehiculos.tecnologias')));


Route::screen('vehiculos/tecnologias', TecnologiaVehiculosListScreen::class)
    ->name('platform.vehiculos.tecnologias')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Tecnologías de Vehiculos'), route('platform.vehiculos.tecnologias')));

//detalle tecnologia

Route::screen('vehiculos/detalle-tecnologias/create', DetalleTecnologiaVehiculosEdiScreen::class)->name('platform.vehiculos.detalle-tecnologias.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.vehiculos.detalles-tecnologias')
            ->push(__('Añadir detalle de tecnología vehículo'), route('platform.vehiculos.detalles-tecnologias'));
    });


Route::screen('vehiculos/detalle-tecnologias/{tecnologia?}/edit', DetalleTecnologiaVehiculosEdiScreen::class)
    ->name('platform.vehiculos.detalle-tecnologias.edit')
    ->breadcrumbs(fn (Trail $trail, $detalle) => $trail
        ->parent('platform.vehiculos.detalles-tecnologias')
        ->push(__('Editar detallle tecnología vehiculo'), route('platform.vehiculos.detalles-tecnologias')));


Route::screen('vehiculos/detalles-tecnologias', DetalleTecnologiaVehiculosListScreen::class)
    ->name('platform.vehiculos.detalles-tecnologias')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Detalle tecnologías Vehiculos'), route('platform.vehiculos.detalles-tecnologias')));


//kilometros



Route::screen('vehiculos/kilometraje/{kilometraje?}/edit', KilometrosVehiculosEditScreen::class)
    ->name('platform.vehiculos.kilometraje.edit')
    ->breadcrumbs(fn (Trail $trail, $kilometraje) => $trail
        ->parent('platform.vehiculos')
        ->push(__('Editar detallle tecnología vehiculo'), route('platform.vehiculos')));

Route::screen('vehiculos/kilometros', KilometrosVehiculosScreen::class)
    ->name('platform.vehiculos.kilometros')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Kilometros Vehiculos'), route('platform.vehiculos.kilometros')));

//repostajes

Route::screen('vehiculos/repostajes', RespostajesVehiculosScreen::class)
    ->name('platform.vehiculos.repostajes')
    ->breadcrumbs(fn (Trail $trail) => $trail

        ->parent('platform.vehiculos')
        ->push(__('Kilometros Vehiculos'), route('platform.vehiculos.repostajes')));
