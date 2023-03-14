<?php

namespace App\Orchid\Layouts\Vehiculos;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Field;

class VehiculoKilometrajeTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
 protected $target = 'kilometrajes';




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
        return   [

            TD::make('fecha',__('Fecha registro de datos'))->cantHide(false),
            TD::make('importe',__('Kilometraje'))->cantHide(false)
                ->render(function($model){
                    return $model->kilometraje . ' km.';
                }),
            
        
                TD::make(__('Actions'))
                ->cantHide(false)
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
            //    ->canSee($this->roles_permitidos>0)
                ->render(fn ($model) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([
        
                        Link::make(__('Edit'))
                            ->route('platform.vehiculos.kilometraje.edit', [$model])
                            //->canSee($this->roles_permitidos>0)
                            ->icon('pencil'),
        
                        Button::make(__('Delete'))
                            ->icon('trash')
                          //  ->canSee($this->roles_permitidos>0)
                            ->confirm(__('El registro seleccionado se va eliminar, ¿está usted seguro?'))
                            ->method('removeKilometraje', [
                                'id' => $model->id,
                            ]),
                        
                    ])),
        ];
    }

    
}
