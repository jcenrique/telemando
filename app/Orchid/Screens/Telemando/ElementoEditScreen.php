<?php

namespace App\Orchid\Screens\Telemando;

use App\Models\Elemento;
use App\Models\Equipo;
use App\Models\Ubicacion;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ElementoEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $ubicacion;
    public $elementos;
   
    public function query(Ubicacion $ubicacion): iterable
    {
      
        return [
            'ubicacion' =>  Ubicacion::where('id', $ubicacion->id)->with(['elementos', 'equipos'])->first(),
           'elementos' => $ubicacion->elementos,
           
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Editar elementos ubicación: ') . $this->ubicacion->ubicacion;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Añadir elemento'))
            ->icon('plus')
            ->method('añadirElemento')
            //->route('platform.elementos.edit',[$this->ubicacion])
          //  ->canSee($this->ubicacion->exists),
        
        ];
    }

    /**
     * The screen's layout elements.
     *
     * 
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {


        return [

            Layout::columns([
                Group::make([
                    Select::make('equipos')
                        ->title(__('Tipo equipo'))
                        ->required()
                        ->fromQuery(Equipo::whereIn('id', Arr::pluck($this->ubicacion->equipos->all(), ['id'])), 'equipo', 'id'),

                    Input::make('elemento')
                        ->required()
                        ->title('Nombre elemento'),
                ])
            ]),





          
        ]; 
       
    }

    public function añadirElemento()        
    {
        Toast::info(__('Elemento añadido con éxito'));
        return redirect()->route('platform.elementos.edit', $this->ubicacion->id);
    }
}
