<?php

namespace App\Orchid\Actions;

use Illuminate\Support\Collection;
use Orchid\Crud\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;

class DeleteAction extends Action
{
    /**
     * The button of the action.
     *
     * @return Button
     */
    public function button(): Button
    {
        return Button::make(__('Eliminar marcados'))
            ->confirm(__('Desea eliminar los elementos seleccionados'))    
        ->icon('trash');
    }

    /**
     * Perform the action on the given models.
     *
     * @param \Illuminate\Support\Collection $models
     */
    public function handle(Collection $models)
    {
        $models->each(function ($model, $key) {
            $model->delete();
        });

        Toast::message(__('Elementos eliminados!'));
    }
}
