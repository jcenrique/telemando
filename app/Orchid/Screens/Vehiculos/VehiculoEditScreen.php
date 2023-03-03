<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Http\Requests\VehiculoRequest;
use App\Models\Departamento;
use App\Models\Kilometraje;
use App\Models\Tipo;
use App\Models\Tipovehiculo;
use App\Models\Vehiculo;
use App\Orchid\Layouts\Vehiculos\MarcaVehiculoListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;

use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VehiculoEditScreen extends Screen
{

    public $vehiculo;

    private $roles_permitidos;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Vehiculo $vehiculo): iterable
    {
        $this->roles_permitidos = Auth::user()->getRoles()->whereIn('slug', ['flota', 'admin'])->count();
        $user_id =  Auth::user()->id;
        if($this->roles_permitidos == 0){
            $array_departamentos = Departamento::where('user_id', $user_id)->get()->pluck('id')->toArray();
            if(sizeof( $array_departamentos) > 0) $this->roles_permitidos =1;
        }else{
            $array_departamentos = Departamento::all()->pluck('id')->toArray();
        }

   

        return [
            'vehiculo' => $vehiculo,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->vehiculo->exists ? __('Editar vehículo') : ('Crear nuevo vehículo');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Crear')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->vehiculo->exists && ($this->roles_permitidos>0)),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->vehiculo->exists && ($this->roles_permitidos>0)),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->vehiculo->exists && ($this->roles_permitidos>0)),

            Button::make('Baja')
                ->icon('thumbs-down')
                ->method('baja')
                ->canSee($this->vehiculo->exists && ($this->vehiculo->fecha_baja == null) && ($this->roles_permitidos>0)),

            Button::make('Alta')
                ->icon('thumbs-up')
                ->method('alta')
                ->canSee($this->vehiculo->exists && ($this->vehiculo->fecha_baja != null) && ($this->roles_permitidos>0)),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {


        return [


            Layout::rows([


                Group::make([
                    Input::make('vehiculo.matricula')
                        ->title(__('Matrícula'))
                        ->mask('9999 AAA')
                        ->required()
                        ->help(__('Introduzca la matrícula del vehículo')),

                    Select::make('vehiculo.tipovehiculo_id') //boton de nuevo tipo
                        ->title(__('Tipo vehículo'))
                        ->fromModel(Tipovehiculo::class, 'tipo')
                        ->empty()
                        ->runBeforeRender()->fromModel(Tipovehiculo::class, 'tipo')
                        ->required()
                        ->help(__('Seleccione el tipo de vehículo')),
                ]),
            ]),


            MarcaVehiculoListener::class,

            Layout::rows([
                Group::make([



                    Select::make('vehiculo.departamento_id')
                        ->empty()
                        ->required()
                        ->fromModel(Departamento::class, 'departamento')
                        ->title(__('Departamento')),

                    DateTimer::make('vehiculo.fecha_matriculacion')
                        ->placeholder(_('Seleccione una fecha'))
                        ->format('Y-m-d')
                        ->title(__('Fecha matriculación'))
                        ->help('Seleccione la fecha de matriculación'),


                ]),

                Group::make([
                    Select::make('vehiculo.regimen')
                        ->title(__('Régimen'))
                        ->options(['PROPIEDAD' => __('PROPIEDAD'), 'RENTING' => __('RENTING')])
                        ->help(__('Seleccione que tipo de régimen del vehículo')),

                    Input::make('vehiculo.kilometraje_inicial')
                        ->type('number')
                        ->title('Kilometraje inicial')
                        ->help(__('Introduzca la primera kilometración conocida')),
                    TextArea::make('vehiculo.observacion')
                        ->rows(4)
                        ->title(__('Observación'))
                ]),

              

            ]),
            Layout::columns([
 //kilometros
 Layout::table('vehiculo.kilometrajes',[
    TD::make('fecha',__('Fecha registro de datos'))->cantHide(false),
    TD::make('kilometraje',__('Kilometraje'))->cantHide(false)
        ->render(function($model){
            return $model->kilometraje . ' km.';
        }),
    

        TD::make(__('Actions'))
        ->cantHide(false)
        ->align(TD::ALIGN_CENTER)
        ->width('100px')
        ->canSee($this->roles_permitidos>0)
        ->render(fn ($model) => DropDown::make()
            ->icon('options-vertical')
            ->list([

                Link::make(__('Edit'))
                    ->route('platform.vehiculos.kilometraje.edit', [$model])
                    ->canSee($this->roles_permitidos>0)
                    ->icon('pencil'),

                Button::make(__('Delete'))
                    ->icon('trash')
                    ->canSee($this->roles_permitidos>0)
                    ->confirm(__('El registro seleccionado se va eliminar, ¿está usted seguro?'))
                    ->method('removeKilometraje', [
                        'id' => $model->id,
                    ]),
                
            ])),

 ])->title(__('Kilometros')),

//kilometros
Layout::table('vehiculo.repostajes',[
    TD::make('fecha',__('Fecha registro de datos'))->cantHide(false),
    TD::make('litros',__('Litros'))->cantHide(false)
        ->render(function($model){
            return $model->litros . ' l.';
        }),
        TD::make('importe',__('Importe'))->cantHide(false)
        ->render(function($model){
            return $model->inporte . ' €';
        }),
    

        TD::make(__('Actions'))
        ->cantHide(false)
        ->align(TD::ALIGN_CENTER)
        ->width('100px')
        ->canSee($this->roles_permitidos>0)
        ->render(fn ($model) => DropDown::make()
            ->icon('options-vertical')
            ->list([

                Link::make(__('Edit'))
                    //->route('platform.vehiculos.kilometraje.edit', [$model])
                    ->canSee($this->roles_permitidos>0)
                    ->icon('pencil'),

                Button::make(__('Delete'))
                    ->icon('trash')
                    ->canSee($this->roles_permitidos>0)
                    ->confirm(__('El registro seleccionado se va eliminar, ¿está usted seguro?')),
                    // ->method('removeKilometraje', [
                    //     'id' => $model->id,
                    // ]),
                
            ])),

 ])->title(__('Repostajes')),
            ]),
           
        ];
    }

    public function asyncMarcaTecnologia($var)
    {


        return [


            'vehiculo.marcavehiculo_id' => $var['marcavehiculo_id'],
            'vehiculo.modelovehiculo_id' => $var['modelovehiculo_id'],
            'vehiculo.tecnologia_id' =>  $var['tecnologia_id'],
            'vehiculo.detalletecnologia_id' => $var['detalletecnologia_id'],


        ];
    }


    public function createOrUpdate(Vehiculo $vehiculo, VehiculoRequest $request)
    {


        $vehiculo->fill($request->get('vehiculo'))->save();
        $this->vehiculo = $vehiculo;
        Toast::info($this->vehiculo->exists ? __('Registro modificado con éxito.') : __('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos');
    }


    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.tipos');
    }

    public function removeKilometraje(Request $request)
    {
        Kilometraje::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    
    }
}
