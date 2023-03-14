<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Repostaje;
use App\Models\Vehiculo;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;



class RepostajeVehiculoLayoutTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'repostajes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        $col_repostajes = Repostaje::all('combustible')->unique('combustible')->sort()->pluck('combustible');
        $array_repostajes = [];
        foreach ($col_repostajes as $key => $value) {
            $array_repostajes = $array_repostajes + [$value => $value];
        }

        $col_establecimientos = Repostaje::all('establecimiento')->unique('establecimiento')->sort()->pluck('establecimiento');
        $array_establecimientos = [];
        foreach ($col_establecimientos as $key => $value) {
            $array_establecimientos = $array_establecimientos + [$value => $value];
        }

        $col_vehiculos = Repostaje::with('vehiculo')->select('vehiculo_id')->get()->unique('vehiculo_id')->sort();
        $array_vehiculos = [];
        //dd($col_vehiculos);
        
        foreach ($col_vehiculos as $key => $value) {
           $vehiculo = Vehiculo::withTrashed('id' , $value->vehiculo_id)->first();
           
            $array_vehiculos = $array_vehiculos + [$vehiculo->id => $vehiculo->matricula];
           
            
        }



        return [
            //TD::make('id'),

            TD::make('vehiculo_id', __('Vehículo'))->sort()->filter(TD::FILTER_SELECT, $array_vehiculos)
                ->render(function ($model) {
                    return   Link::make(Vehiculo::find($model->vehiculo_id)->matricula)
                      
                        ->route('platform.vehiculo.edit',[$model->vehiculo_id]);
                }), 
            
            TD::make('fecha', __('Fecha'))->filter(TD::FILTER_DATE_RANGE)->sort(),
            TD::make('poblacion', __('Población'))->sort(),
            TD::make('establecimiento', __('Establecimiento'))->sort()->filter(TD::FILTER_SELECT, $array_establecimientos),
            TD::make('kilometraje', __('Kilómetraje')),
            TD::make('combustible')->sort()->filter(TD::FILTER_SELECT, $array_repostajes),
            TD::make('litros', __('Litros')),
            TD::make('importe', __('Importe')),



        ];
    }
}
