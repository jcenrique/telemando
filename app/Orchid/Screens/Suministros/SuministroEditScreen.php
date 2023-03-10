<?php

namespace App\Orchid\Screens\Suministros;

use App\Http\Requests\SuministroRequest;
use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Tipo;
use App\Models\Zona;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SuministroEditScreen extends Screen
{

    public $suministro;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Suministro $suministro): iterable
    {
        return [
            'suministro' => $suministro
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->suministro->exists ? __('Editar suministro: ') . $this->suministro->CUP : __('Crear suministro');
    }
    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Crear'))
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->suministro->exists),

            Button::make(__('Update'))
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->suministro->exists),

            Button::make(__('Remove'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->suministro->exists),


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
                    Select::make('suministro.zona_id')
                        ->required()
                        ->style('width:200px;')
                        ->title(__('Zona'))
                        ->fromModel(Zona::class, 'zona', 'id'),


                    Input::make('suministro.poblacion')
                        ->required()
                        ->style('width:200px;')
                        ->title(__('Poblaci??n'))

                        ->placeholder(__('Introduzca la poblaci??n')),

                    Input::make('suministro.direccion')
                        ->required()
                        ->style('width:100cm;')


                        ->title(__('Direcci??n'))
                        ->placeholder(__('Introduzca la direcci??n')),


                ])->autoWidth()


            ])->title(__('Situaci??n del suministro')),

            Layout::rows([
                Group::make([
                    Input::make('suministro.CUP')
                        ->required()
                        ->title(__('CUP'))
                        ->placeholder(__('Introduzca el CUP')),

                    Select::make('suministro.telegestion')
                        ->title(__('Telegesti??n'))
                        ->empty()
                        ->options([ 1 =>  'SI', 0 => 'NO'])
                        ->help(__('Seleccionar si dispone de telemedida, si se conoce')),

                    Select::make('suministro.tipo_id')
                        ->empty()
                        ->title(__('Tipo de suministro'))
                        ->fromModel(Tipo::class, 'tipo', 'id')
                        ->help(__('Seleccionar el tipo suministro si se conoce')),
                    Input::make('suministro.instalacion')

                        ->title(__('Instalaci??n'))
                        ->placeholder(__('Introduzca la instalaci??n'))
                        ->help(__('Debe introducir el tipo instalaci??n a la que el suministro porporciona energ??a')),
                ]),


                Group::make([
                    Input::make('suministro.contrato')
                        ->required()
                        ->type('number')
                        ->title(__('Num. Contrato'))
                        ->placeholder(__('Introduzca el n??mero de contrato')),

                    Input::make('suministro.num_contador')
                        ->required()
                        ->title(__('Num. Contador'))
                        ->placeholder(__('Introduzca el numero de contrato'))
                        ->help(__('Debe introducir el numero de contador del suministro si se conoce')),

                    Select::make('suministro.tarifa_id')
                        ->empty()
                        ->required()
                        ->title(__('Tarifa aplicada'))
                        ->fromModel(Tarifa::class, 'tarifa', 'id'),

                ]),

            ])->title(__('Datos b??sicos del suministro')),

            Layout::rows([
                Group::make([

                    Input::make('suministro.P1')
                        ->required()
                        ->title(__('P1'))
                        ->placeholder(__('Introduzca la potencia en KW')),
                    Input::make('suministro.P2')
                        ->required()
                        ->title(__('P2'))
                        ->placeholder(__('Introduzca la potencia en KW')),
                    Input::make('suministro.P3')

                        ->title(__('P3'))
                        ->placeholder(__('Introduzca la potencia en KW')),
                    Input::make('suministro.P4')

                        ->title(__('P4'))
                        ->placeholder(__('Introduzca la potencia en KW')),
                    Input::make('suministro.P5')

                        ->title(__('P5'))
                        ->placeholder(__('Introduzca la potencia en KW')),
                    Input::make('suministro.P6')

                        ->title(__('P6'))
                        ->placeholder(__('Introduzca la potencia en KW')),

                ])
            ])->title(__('Potencias')),

            Layout::rows([

                Group::make([

                    Select::make('suministro.tension_id')
                        ->empty()
                        ->required()
                        ->title(__('Tensi??n del suministro'))
                        ->fromModel(Tension::class, 'tension', 'id'),
                    Select::make('suministro.relacion_id')
                        ->empty()

                        ->title(__('Relaci??n de transformaci??n'))
                        ->fromModel(Relacion::class, 'relacion', 'id')
                        ->help(__('Debe elegir la relaci??n de transformaci??n del suministro si se conoce')),

                    Select::make('suministro.medida')
                        ->empty()
                        ->options(['DIRECTA' => 'DIRECTA', 'INDIRECTA' => 'INDIRECTA'])
                        ->title(__('Tipo de medida'))
                        ->help(__('Debe elegir el tipo de medida del suministro si se conoce')),
                    Select::make('suministro.icp')
                        ->empty()
                        ->options(['DISTRIBUIDORA' => 'DISTRIBUIDORA', 'SI' =>  'SI', 'NO' => 'NO'])
                        ->title(__('ICP'))
                        ->help(__('Debe elegir ICP del suministro si se conoce')),
                    
                        Select::make('suministro.comercializadora')
                        ->empty()
                        ->options(['CUR' => 'CUR', 'CLIENTES' =>  'CLIENTES'])
                        ->title(__('ICP'))
                        ->help(__('Debe elegir ICP del suministro si se conoce')),

                    Select::make('suministro.contador')
                        ->empty()
                        ->options(['DISTRIBUIDORA' => 'DISTRIBUIDORA', 'SI' => 'SI', 'CLIENTE' => 'CLIENTE', 'i-DE' =>  'i-DE'])
                        ->title(__('Contador'))
                        ->help(__('Debe elegir la pertenecia del contador del suministro si se conoce')),

                ]),




                TextArea::make('suministro.observacion')
                    ->rows(4)

                    ->title(__('Observaci??n'))
                    ->help(__('Introduzca cualquier anotaci??n que pueda ampliar la informaci??n del suministro')),



            ])->title(__('Indicadores'))


        ];
    }

    public function createOrUpdate(Suministro $suministro, SuministroRequest $request)
    {


        // dd($request);

        $suministro->fill($request->get('suministro'))->save();
        $this->suministro = $suministro;



        Toast::info($this->suministro->exists ? __('Registro actualizado con ??xito') : __('Registro creado con ??xito'));

        return redirect()->route('platform.suministros');
    }

    /**
     * @param Post $suministro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Suministro $suministro)
    {
        $suministro->delete();

        Toast::info(__('Registro eliminado con ??xito'));

        return redirect()->route('platform.suministros');
    }
}
