<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Tipovehiculo;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TipoVehiculoLayoutTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tipos';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('tipo', __('Tipo'))->sort(),
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
            ->render(fn (Tipovehiculo $tipo) => DropDown::make()
                ->icon('options-vertical')
                ->list([

                    Link::make(__('Edit'))
                        ->route('platform.vehiculos.tipo.edit', [$tipo])
                        ->icon('pencil'),

                    Button::make(__('Delete'))
                        ->icon('trash')
                        ->confirm(__('El registro: <strong> ' . $tipo->tipo . '</strong> seleccionado se va eliminar, ¿está usted seguro?'))
                        ->method('remove', [
                            'id' => $tipo->id,
                        ]),
                ])),
        ];
    }

    protected function hoverable(): bool
    {
        return true;
    }
}
