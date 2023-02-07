<?php

namespace App\Orchid\Layouts\Telemando;

use App\Models\Equipo;
use App\Models\Ubicacion;
use Illuminate\Support\Arr;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;

class EquiposListener extends Listener
{
    /**
     * List of field names for which values will be joined with targets' upon trigger.
     *
     * @var string[]
     */
    protected $extraVars = [
    ];

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
       
       'equipo'
       
    ];

  
    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncGetEquipo';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {


        $valor =   $this->query['ubicacion_id'];
       

        
        

        //dd($this->query['ubicacion']);
       //$arr_equipos = $this->query['ubicacion']->id)->equipos->modelKeys();

        return [
            Layout::rows([
                Input::make('ubicacion.id') ,
               
                Select::make('equipo')
                    ->empty(__('Sin selección'))
                    ->title(__('Tipo equipo'))
                    ->required()
                    ->fromQuery(Equipo::whereIn('id' , Ubicacion::find( $valor)->equipos->modelKeys()),'equipo','id'),
                
               
                 Input::make('equipo_id') ,
                
                    
                 

             
            ]),
          
        ];
    }
}
