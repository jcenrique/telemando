<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Detalletecnologia;
use App\Models\Tecnologia;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DetalleTecnologiaVehiculosLayautTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'detalles';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('detalle',__('Sub-tecnología'))->sort(),
            TD::make('tecnologia_id', __('Tecnología'))
            ->render(function ($model) {
                return Tecnologia::find($model->tecnologia_id)->tecnologia;
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
            ->render(fn (Detalletecnologia $detalle) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.vehiculos.detalle-tecnologias.edit', [$detalle])
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('El registro: <strong> ' . $detalle->detalle . '</strong> seleccionado se va eliminar, ¿está usted seguro?'))
                        ->method('remove', [
                            'id' => $detalle->id,
                        ]),
                ])),

        ];
    }
    protected function hoverable(): bool
    {
        return true;
    }
}
