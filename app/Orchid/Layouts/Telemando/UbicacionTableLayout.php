<?php

namespace App\Orchid\Layouts\Telemando;

use App\Models\Alarma;
use App\Models\Ubicacion;
use App\Models\Zona;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UbicacionTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'ubicaciones';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        return [
            TD::make('ubicacion')
                ->filter()
                ->sort(),
                
            TD::make('zona_id', __('Zona'))
                ->sort()

                ->render(function ($model) {
                    return Zona::find($model->zona_id)->zona;
                }),

            


            TD::make('equipos', __('Tipos de Equipos'))


                ->render(function ($model) {
                   
                       
                    return  $model->equipos->implode('equipo', ' <BR>') ;
                }),

            TD::make('comentario'),


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
                ->render(fn (Ubicacion $ubicacion) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.ubicacion.edit', [$ubicacion])
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('El registro: <strong> ' . $ubicacion->ubicacion . '</strong> seleccionado se va eliminar, ¿está usted seguro?'))
                            ->method('remove', [
                                'id' => $ubicacion->id,
                            ]),
                    ])),

        ];
    }
}
