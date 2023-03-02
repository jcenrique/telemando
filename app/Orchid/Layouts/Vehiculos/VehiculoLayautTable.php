<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Departamento;
use App\Models\Detalletecnologia;
use App\Models\Marcavehiculo;
use App\Models\Modelovehiculo;
use App\Models\Tecnologia;
use App\Models\Tipovehiculo;
use App\Models\User;
use App\Models\Vehiculo;
use App\Orchid\Filters\MatriculaFilter;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VehiculoLayautTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'vehiculos';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        
        return [

            //por si hace falta realizar acciones masivas
        //     TD::make()
        //     ->render(function (Vehiculo $vehiculo){
        //         return CheckBox::make('vehiculos[]')
        //             ->value($vehiculo->id)
        //             //->placeholder($vehiculo->matricula)
        //             ->checked(false);
        // }),
            TD::make('matricula', __('Matrícula'))->sort(),
            
            TD::make('tipovehiculo_id', __('Tipo de Vehículo'))->sort()
                ->filter(TD::FILTER_SELECT, Tipovehiculo::all('id', 'tipo')->pluck('tipo', 'id',)->toArray())
                ->render(function ($model) {
                    return Tipovehiculo::find($model->tipovehiculo_id)->tipo;
                }),
            TD::make('marcavehiculo_id', __('Marca/Modelo'))->sort()
                ->filter(TD::FILTER_SELECT, Marcavehiculo::all('id', 'marca')->pluck('marca', 'id',)->toArray())
                ->render(function ($model) {
                    $marca = Marcavehiculo::find($model->marcavehiculo_id)->marca;
                    $modelo = Modelovehiculo::find($model->modelovehiculo_id)->modelo;
                    //return $marca . '<BR><small class="text-muted">' . $modelo . '</small>';
                    return view('vendor.platform.layouts.fila-doble', ['var1' => $marca, 'var2' => $modelo]);
                }),


            TD::make('departamento_id', __('Departamento/Responsable'))->sort()
                ->filter(TD::FILTER_SELECT, Departamento::all('id', 'departamento')->pluck('departamento', 'id',)->toArray())
                ->render(function ($model) {
                    $departamento = Departamento::find($model->departamento_id)->departamento;
                    $user = User::find(Departamento::find($model->departamento_id)->user_id)->name;

                    return view('vendor.platform.layouts.fila-doble', ['var1' => $departamento, 'var2' => $user]);
                }),

            TD::make('tecnologia_id', __('Tecnología'))->sort()
                ->filter(TD::FILTER_SELECT, Tecnologia::all('id', 'tecnologia')->pluck('tecnologia', 'id',)->toArray())
                ->render(function ($model) {
                    $tecnologia = Tecnologia::find($model->tecnologia_id)->tecnologia;
                    $detalle = $model->detalletecnologia_id != null ? Detalletecnologia::find($model->detalletecnologia_id)->detalle : '';

                    return view('vendor.platform.layouts.fila-doble', ['var1' => $tecnologia, 'var2' => $detalle]);
                }),

            TD::make('regimen', __('Régimen'))->sort()->filter(TD::FILTER_SELECT, ['PROPIEDAD' => 'PROPIEDAD', 'RENTING' => 'RENTING']),
            
            TD::make('fecha_matriculacion', __('Fecha matriculación'))->sort()
                ->filter(TD::FILTER_DATE_RANGE)

                ->render(function ($model) {
                    return $model->fecha_matriculacion;
                }),

            TD::make('kilometraje_inicial', __('Kilometraje inicial'))
                ->render(function ($model) {
                    return $model->kilometraje_inicial . ' km.';
                }),

            TD::make('kilometrajes', __('Kilometraje actual'))
                ->render(function ($model) {
                    return $model->kilometrajes->max('kilometraje') . ' km.';
                }),

                //no funciona
            // TD::make('fecha_baja', __('Fecha baja'))->sort()
            //     ->canSee(!is_null( $this->query['model']['fecha_baja']))
            //     ->filter(TD::FILTER_DATE_RANGE)

            //     ->render(function ($model) {
            //         return $model->fecha_baja;
            //     }),

            TD::make('observacion', __('Observación')),
                

            TD::make('created_at', __('Date of creation'))
                ->defaultHidden(true)
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', __('Update date'))
                ->defaultHidden(true)
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Vehiculo $vehiculo) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.vehiculo.edit', [$vehiculo])
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('El registro: <strong> ' . $vehiculo->matricula . '</strong> seleccionado se va eliminar, ¿está usted seguro?'))
                            ->method('remove', [
                                'id' => $vehiculo->id,
                            ]),
                        Button::make(__('Baja'))
                            ->icon('car-burst')
                            ->canSee($vehiculo->fecha_baja ==null)
                            ->confirm(__('El vehiculo: <strong> ' . $vehiculo->matricula . '</strong> será dado de baja con fecha de hoy, pero no eliminado, ¿está usted seguro?'))
                            ->method('baja', [
                                'id' => $vehiculo->id,
                            ]),
                            Button::make(__('Alta'))
                            ->icon('cash-register')
                            ->canSee($vehiculo->fecha_baja !=null)
                            ->confirm(__('El vehiculo: <strong> ' . $vehiculo->matricula . '</strong> será dado de alta, ¿está usted seguro?'))
                            ->method('alta', [
                                'id' => $vehiculo->id,
                            ]),
                    ])),
        ];
    }
    protected function hoverable(): bool
    {
        return true;
    }
}
