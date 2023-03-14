<?php

namespace App\Orchid\Layouts\Vehiculos;

use App\Models\Departamento;
use App\Models\User;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Select;

use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class KilometrosVehiculoListener extends Listener
{
    /**
     * List of field names for which values will be joined with targets' upon trigger.
     *
     * @var string[]
     */
    protected $extraVars = [];

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [
        'departamento_id'
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
    protected $asyncMethod = 'asyncKilometros';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        //dd(Auth::user()->getRoles());
        $roles_permitidos = Auth::user()->getRoles()->whereIn('slug', ['flota','admin'])->count();
        $user_id =  Auth::user()->id;
        $user = User::with('departamentos')->where('id',$user_id)->first();
        $departamentos_id = $user->departamentos()->get()->pluck('id')->toArray();

        if($roles_permitidos == 0){
            $array_departamentos =  $departamentos_id;
            if(sizeof( $array_departamentos) > 0) $roles_permitidos =1;
        }else{
            $array_departamentos = Departamento::all()->pluck('id')->toArray();
        }
        
    
        return [

            Layout::rows([
              
                
                Label::make('etiqueta1')
                    ->title(__('No dispone de autorización'))
                   
                    ->canSee($roles_permitidos == 0),


                Select::make('departamento_id')
                    ->canSee($roles_permitidos != 0)
                    ->disabled($roles_permitidos == 0)
                    ->title('Departamentos')
                    ->empty()
                    ->required()
                    
                  ->fromQuery(Departamento::whereIn('id' , $array_departamentos),'departamento'),

                Matrix::make('kilometros')
                
                    ->canSee($roles_permitidos != 0)
                    ->title('Kilometros vehículos')
                    ->columns([
                        __('Matrícula') => 'vehiculo_id',
                        __('Kilometros') => 'kilometraje',
                        __('Fecha') => 'fecha',

                    ])
                    ->fields([
                        'vehiculo_id'   => Select::make('vehiculo_id')
                            ->required()
                            ->empty(__('Selecciona o escribe la matrícula'))
                            ->fromQuery(Vehiculo::where('departamento_id', '=', $this->query['departamento_id']), 'matricula'),
                        'kilometraje' => Input::make('kilometraje')->type('number')->required()->placeholder(__('Introduce los kilometros')),
                        'fecha' => DateTimer::make('fecha')->placeholder(__('Introduce la fecha'))->required()->format('Y-m-d'),


                    ]),
                Label::make('etiqueta')
                    ->canSee($roles_permitidos != 0)
                    ->title(__('Las matrículas duplicadas no se registrarán, si es necesario realizar dos anotaciones del mismo vehículo deberán hacerse por separado'))
            ])

        ];
    }
}
