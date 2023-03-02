<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Departamento;
use App\Models\Detalletecnologia;
use App\Models\Marcavehiculo;
use App\Models\Modelovehiculo;
use App\Models\Tecnologia;
use App\Models\Tipovehiculo;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

use Orchid\Screen\Layouts\Listener;
use Orchid\Support\Facades\Layout;


class MarcaVehiculoListener extends Listener
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
       
        'vehiculo.marcavehiculo_id',
        'vehiculo.modelovehiculo_id',
       'vehiculo.tecnologia_id',
       'vehiculo.detalletecnologia_id'
        
       
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
    protected $asyncMethod = 'asyncMarcaTecnologia';


    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
       //  dd( $this->query['vehiculo.marcavehiculo_id']);
     //  dd($this->query['vehiculo']['marcavehiculo_id']);
        return [
            Layout::rows([
                
                Group::make([
                    Select::make('vehiculo.marcavehiculo_id')
                    ->empty()
                    ->required()
                    ->fromModel(Marcavehiculo::class, 'marca')
                    ->title(__('Marca')),
                Select::make('vehiculo.modelovehiculo_id')
                    ->empty()
                    ->required()
                    ->title(__('Modelo'))
                    ->fromQuery(Modelovehiculo::where('marcavehiculo_id', '=', $this->query['vehiculo.marcavehiculo_id']), 'modelo'),
           
                
                Select::make('vehiculo.tecnologia_id')
                    ->empty()
                    ->required()
                    ->fromModel(Tecnologia::class, 'tecnologia')
                    ->title(__('Tecnología')),
                Select::make('vehiculo.detalletecnologia_id')
                    ->empty()
                   
                    ->title(__('Sub-Tecnología'))
                    ->fromQuery(Detalletecnologia::where('tecnologia_id', '=', $this->query['vehiculo.tecnologia_id']), 'detalle'),
                ])
                    
              



            ]),
        ];
    }
}
