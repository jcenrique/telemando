<?php

namespace App\Orchid\Screens\Telemando;

use App\Models\Elemento;
use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Orchid\Layouts\Telemando\EquiposListener;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class ElementoEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
   // public $ubicacion;
  //  public $elementos;

   // public $equipo_id;

    public function query(): iterable
    {

        return [
            'ubicacion' =>  Ubicacion::where('id', 2)->with(['elementos', 'equipos'])->first(),
          //  'elementos' => $ubicacion->elementos,
           'ubicacion_id' => 2
            
            
            //Arr::pluck($ubicacion->equipos->all(), ['id']),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'prueba'; // __('Editar elementos ubicación: ') . $this->ubicacion->ubicacion;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

            //->route('platform.elementos.edit',[$this->ubicacion])
            //  ->canSee($this->ubicacion->exists),

            // ModalToggle::make(__('Añadir elemento'))
            //     ->modal('crearUbicacionModal')
            //     ->method('añadirElemento')

            //     ->asyncParameters([
            //         'ubicacion' => $this->ubicacion->id,
            //         'elemento_id' => $this->ubicacion->equipos(),
                  
            //     ])
            //     ->icon('plus'),
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

            
                
                    EquiposListener::class,
                   
             

                // Layout::table('elementos', [
                //     TD::make('elemento')
                // ])

                //     ->title(__('Elementos disponibles')),


           

            // Layout::modal('crearUbicacionModal', [
            //     Layout::rows([
            //         Input::make('elemento')
            //             ->required()
            //             ->title('Nombre elemento'),
            //     ])->async('asyncGetElemento')

            // ])




        ];
    }

    public function añadirElemento(Request $request, Ubicacion $ubicacion)
    {
        dd($request->all());
        $elemento = new Elemento(
            [
                'elemento' => $request->get('elemento'),
                'ubicacion_id' =>  $ubicacion->id,
               // 'equipo_id' => 
            ]);
        $ubicacion->elementos()->save($elemento);
        Toast::info(__('Elemento añadido con éxito'));
        return redirect()->route('platform.elementos.edit', $ubicacion->id);
    }

    // public function asyncGetElemento(Ubicacion $ubicacion): iterable
    // {
    //     return [
    //         'ubicacion' => $ubicacion,
    //     ];
    // }

    public function asyncGetEquipo( Equipo $equipo)
    {

       
        return [
            'equipo' => $equipo,
            'equipo_id' => $equipo->id,
           
        ];
    }
}
