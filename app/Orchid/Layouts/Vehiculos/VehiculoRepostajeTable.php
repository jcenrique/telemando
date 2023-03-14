<?php

namespace App\Orchid\Layouts\Vehiculos;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VehiculoRepostajeTable extends Table
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

    public function __construct(string $title = null)
    {

        $this->title = $title;
    }


    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

        return [
            TD::make('fecha', __('Fecha registro de datos'))->cantHide(false)->width('180px'),
            TD::make('poblacion', __('Población'))->cantHide(false),
            TD::make('kilometraje', __('Kilometros'))->cantHide(false),
            TD::make('litros', __('Litros'))->cantHide(false)
                ->render(function ($model) {
                    return $model->litros . ' l.';
                }),
            TD::make('importe', __('Importe'))->cantHide(false)
                ->render(function ($model) {
                    return $model->importe . ' €';
                }),
            TD::make('combustible', __('Combustible'))->cantHide(false),
            // 


            TD::make(__('Actions'))
                ->cantHide(false)
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                //->canSee($this->roles_permitidos>0)
                ->render(fn ($model) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            //->route('platform.vehiculos.kilometraje.edit', [$model])
                            // ->canSee($this->roles_permitidos>0)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            //->canSee($this->roles_permitidos>0)
                            ->confirm(__('El registro seleccionado se va eliminar, ¿está usted seguro?')),
                        // ->method('removeKilometraje', [
                        //     'id' => $model->id,
                        // ]),

                    ])),

        ];
    }

    public function total(): array
    {

        return [
            TD::make('total_kilometros')
                ->align(TD::ALIGN_RIGHT)
                ->colspan(2)
                ->render(function () {
                    return 'Total Kilometros: ' . $this->query['total_kilometros'] . ' km.';
                }),

            TD::make('total_litros')
                ->align(TD::ALIGN_RIGHT)
                ->render(function () {
                    return $this->query['total_litros'] == 0 ? '' : 'Total litros combustible: ' . $this->query['total_litros'] . ' l.';
                }),
            TD::make('media_consumo_combustible')
                ->align(TD::ALIGN_RIGHT)
                ->render(function () {
                    return  $this->query['media_consumo_combustible'] == 0 ? '' : 'Consumo medio combustible: ' . $this->query['media_consumo_combustible'] . ' l/100km.';
                }),

            TD::make('total_litros_gas')
                ->align(TD::ALIGN_RIGHT)
                ->render(function () {
                    return $this->query['total_litros_gas'] == 0 ? '' : 'Total litros gas: ' . $this->query['total_litros_gas'] . ' l.';
                }),

            TD::make('media_consumo_gas')
                ->align(TD::ALIGN_RIGHT)
                ->render(function () {
                    return $this->query['media_consumo_gas'] == 0 ? '' : 'Consumo medio gas: ' . $this->query['media_consumo_gas'] . ' l/100km.';
                }),

        ];
    }
}
// 