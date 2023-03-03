<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Vehiculo;
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
        return [
            // TD::make('id'),
            TD::make('vehiculo_id', __('Vehículo'))->sort()
                ->render(function ($model) {
                    return Vehiculo::find($model->vehiculo_id)->matricula;
                }),
            TD::make('fecha', __('Fecha')),
            TD::make('litros', __('Litros')),
            TD::make('importe', __('Importe')),
            TD::make('combustible', __('Combustible')),


        ];
    }
}
