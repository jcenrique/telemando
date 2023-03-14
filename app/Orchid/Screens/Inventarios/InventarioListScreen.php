<?php

namespace App\Orchid\Screens\Inventarios;

use App\Models\Inventario;
use App\Models\Zona;
use App\Orchid\Filters\WithTrashed;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

use function Clue\StreamFilter\fun;
use function Termwind\render;

class InventarioListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'inventarios' => Inventario::with([ 'atributos'])->filters([WithTrashed::class])->paginate(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Inventario de Instalaciones');
    }

    public function description(): ?string
    {
        return __('Descripción detallada del inventario de Instalaciones de ETS-RFV');
    }

    
    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            
            Link::make(__('Crear'))
                ->icon('pencil')
                ->route('platform.suministro.create'),

            

           
                Button::make(__('Exportar'))
                ->icon('download')
                ->method('export')
                ->parameters(request()->all())
                ->rawClick(),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {

      //  dump($this->query()['inventarios']->propiedades());
        return [

            Layout::selection([ WithTrashed::class]),
           
            Layout::table('inventarios',[
               
                TD::make('inventario',__('Inventario')),
                TD::make('zona_id' ,__('Zona'))
                    ->render(function($model){
                        return Zona::find($model->zona_id)->zona;
                    }),

                TD::make('description' ,__('Descripción')),
                TD::make('atributos' , __('Atributos'))
                    ->render(function($model){
                       
                       
                        return  view('partials.table-atributos' , ['atributos' =>  $model->atributos()->get()]);
                    }
                       
                    
                ),
            ]),
        ];
    }
}
