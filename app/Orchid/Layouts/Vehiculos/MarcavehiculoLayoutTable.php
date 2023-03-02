<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Marcavehiculo;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

use function Termwind\render;

class MarcavehiculoLayoutTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'marcas';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('marca', __('Marca'))->sort(),
            TD::make( __('Modelos'))
                ->render(function ($model) {
                    return  implode(' , ' , $model->modelos->pluck('modelo')->toArray());
                   
                }),
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
            ->render(fn (Marcavehiculo $marca) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.vehiculos.marca.edit', [$marca])
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('El registro: <strong> ' . $marca->marca . '</strong> seleccionado se va eliminar, ¿está usted seguro?'))
                        ->method('remove', [
                            'id' => $marca->id,
                        ]),
                ])),

        ];
    }

    protected function hoverable(): bool
    {
        return true;
    }
}
