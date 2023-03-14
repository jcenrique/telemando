<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Http\Requests\VehiculoRequest;
use App\Models\Departamento;
use App\Models\Kilometraje;
use App\Models\Repostaje;
use App\Models\Tipo;
use App\Models\Tipovehiculo;
use App\Models\Vehiculo;
use App\Orchid\Layouts\Vehiculos\MarcaVehiculoListener;
use App\Orchid\Layouts\Vehiculos\VehiculoKilometrajeTable;
use App\Orchid\Layouts\Vehiculos\VehiculoRepostajeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        if ($this->roles_permitidos == 0) {
            $array_departamentos = Departamento::where('user_id', $user_id)->get()->pluck('id')->toArray();
            if (sizeof($array_departamentos) > 0) $this->roles_permitidos = 1;
        } else {
            $array_departamentos = Departamento::all()->pluck('id')->toArray();
        }

        $max_km = Kilometraje::where('vehiculo_id', $vehiculo->id)->get()->max('kilometraje');
        $min_km = Kilometraje::where('vehiculo_id', $vehiculo->id)->get()->min('kilometraje');
        $total_km = $max_km - $min_km;

        //calcular kilometros gas 
        $repostajes = Repostaje::where('vehiculo_id', $vehiculo->id)->orderByDesc('fecha')->get();
        $kilometros_recorridos_gas = 0;
        $kilometros_recorridos_combustible = 0;
        $posicion = 0;
        $coleccion_gas = new Collection;
        $coleccion_combustible = new Collection;

        foreach ($repostajes as $key => $repostaje) {
            //dump('posicion' . $posicion);
            //   dump('key' . $key);
            if ($key == ($posicion + 1) && $posicion != 0) {
                if ($repostajes[$posicion]->kilometraje != 0 && $repostaje->kilometraje != 0) {
                    $diferencia_kilometros = $repostajes[$posicion]->kilometraje - $repostaje->kilometraje;


                    $coleccion_gas->push([
                        'kilometros' => $diferencia_kilometros,
                        'litros' =>  $repostajes[$posicion]->litros
                    ]);

                    //dump('diferencia kilometros:' .  $diferencia_kilometros . '-> litros:' . $repostajes[$posicion]->litros . ' -> consumo: ' . ($repostajes[$posicion]->litros * 100) / $diferencia_kilometros);
                }


                $posicion = 0;
            }
            //  dump($repostajes[$posicion]->kilometraje);
            if ($repostaje->combustible == 'AUTOGAS') {

                $posicion = $key;
            }
        }

        foreach ($repostajes as $key => $repostaje) {
            //dump('posicion' . $posicion);
            //   dump('key' . $key);
            if ($key == ($posicion + 1)) {
                if ($repostajes[$posicion]->kilometraje != 0 && $repostaje->kilometraje != 0) {
                    $diferencia_kilometros = $repostajes[$posicion]->kilometraje - $repostaje->kilometraje;


                    $coleccion_combustible->push([
                        'kilometros' => $diferencia_kilometros,
                        'litros' =>  $repostajes[$posicion]->litros
                    ]);
                    // dump('diferencia kilometros:' .  $diferencia_kilometros . '-> litros:' . $repostajes[$posicion]->litros . ' -> consumo: ' . ($repostajes[$posicion]->litros * 100) / $diferencia_kilometros);
                }

                $posicion = 0;
            }
            //  dump($repostajes[$posicion]->kilometraje);
            if ($repostaje->combustible != 'AUTOGAS') {

                $posicion = $key;
            }
        }


        if ($vehiculo->tecnologia_id == 5) { // es bi-fuel
            if ($coleccion_gas->sum('kilometros') == 0) {
                $media_consumo_gas = 0;
            } else {
                $media_consumo_gas = number_format(($coleccion_gas->sum('litros') * 100) / $coleccion_gas->sum('kilometros'), 2);
            }
            if ($coleccion_combustible->sum('kilometros') == 0) {
                $media_consumo_combustible = 0;
            } else {
                $media_consumo_combustible = number_format(($coleccion_combustible->sum('litros') * 100) / $coleccion_combustible->sum('kilometros'), 2);
            }
        } elseif($vehiculo->tecnologia_id != 5 && $vehiculo->tecnologia_id != 4) { //no es electrico ni bi-fuel
            $media_consumo_gas = 0;
            $total_litros = Repostaje::where('vehiculo_id', $vehiculo->id)->where('combustible', '!=', 'AUTOGAS')->get()->sum('litros');
            $media_consumo_combustible =   $total_km==0 ?'0': number_format((($total_litros * 100) /  $total_km), 2);
         }else{ //es electrico
            $media_consumo_combustible=0;
            $media_consumo_gas = 0;
         }

        return [
            'vehiculo' => $vehiculo,
            'kilometrajes' => Kilometraje::where('vehiculo_id', $vehiculo->id)->paginate(10),
            'repostajes' => Repostaje::where('vehiculo_id', $vehiculo->id)->orderByDesc('fecha')->paginate(10),

            'total_kilometros' => $total_km,
            'media_consumo_combustible' => $media_consumo_combustible,
            'media_consumo_gas' => $media_consumo_gas,
            'total_litros_gas' => Repostaje::where('vehiculo_id', $vehiculo->id)->where('combustible', 'AUTOGAS')->get()->sum('litros'),
            'total_litros' => Repostaje::where('vehiculo_id', $vehiculo->id)->where('combustible', '!=', 'AUTOGAS')->get()->sum('litros'),
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
                ->canSee(!$this->vehiculo->exists && ($this->roles_permitidos > 0)),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->vehiculo->exists && ($this->roles_permitidos > 0)),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->vehiculo->exists && ($this->roles_permitidos > 0)),

            Button::make('Baja')
                ->icon('thumbs-down')
                ->method('baja')
                ->canSee($this->vehiculo->exists && ($this->vehiculo->fecha_baja == null) && ($this->roles_permitidos > 0)),

            Button::make('Alta')
                ->icon('thumbs-up')
                ->method('alta')
                ->canSee($this->vehiculo->exists && ($this->vehiculo->fecha_baja != null) && ($this->roles_permitidos > 0)),
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
        //    Layout::columns([
        //         //repostajes
        //          new VehiculoRepostajeTable(__('Repostajes vehículo: '  . $this->vehiculo->matricula)),
        //         //   VehiculoRepostajeTable::class,
        //         //kilometros
        //         //   new VehiculoKilometrajeTable(__('Kilometraje')),
        //     ])->canSee( $this->vehiculo->exists),


        Layout::table('repostajes',[
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
        ])

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
