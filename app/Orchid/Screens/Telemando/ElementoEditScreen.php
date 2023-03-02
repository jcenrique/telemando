<?php

namespace App\Orchid\Screens\Telemando;

use App\Imports\AlarmasImport;
use App\Imports\ImportHoja;
use App\Imports\LibroAlarmasImport;
use App\Models\Elemento;
use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Rules\Uppercase;
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
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Fields\Upload;

class ElementoEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $ubicacion;
    public $elementos;


    public $equipo;

    public $equipo_id;


    public function permission(): ?iterable
    {
        return [
            'ubicaciones'
        ];
    }
    public function query(Ubicacion $ubicacion): iterable
    {

        return [
            'ubicacion' =>  Ubicacion::where('id', $ubicacion->id)->with(['elementos', 'equipos'])->first(),
            'elementos' => $ubicacion->elementos,



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
        return  __('Editar ubicación: ') . $this->ubicacion->ubicacion;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [



            ModalToggle::make(__('Cargar alarmas'))
                ->modal('abrirFicheroExcel')
                ->method('importar')
                ->canSee($this->ubicacion->equipos != null)
                ->asyncParameters([

                    //'ubicacion' => $this->ubicacion->id,


                ])
                ->icon('plus'),


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

        $equipos = $this->ubicacion->equipos->setVisible(['equipo', 'id'])->toArray();
        if ($equipos != null) {
            foreach ($equipos as  $key => $equipo) {
                $myArray[$equipo['id']] = $equipo['equipo'];
            };

            foreach ($myArray as  $key => $value) {

                $elementos = Elemento::where('equipo_id', $key)->paginate();
                $tabs[$value] = [

                    Layout::view('admin.ubicacion_elements', ['elementos1' => $elementos])
                ];
            }



            return [

                Layout::tabs(
                    $tabs

                ),

                Layout::modal('abrirFicheroExcel', [
                    Layout::rows([

                        Select::make('equipo_id')
                            ->empty(__('Sin selección'))
                            ->title(__('Tipo equipo'))
                            ->required()
                            ->fromQuery(Equipo::whereIn('id', Ubicacion::find($this->ubicacion->id)->equipos->modelKeys()), 'equipo', 'id'),

                        Input::make('archivo')->type('file')
                            ->title(__('Selecciona un archivo Excel de alarmas'))
                            ->required()


                    ])

                ])->title(__('Cargar fichero Excel de alarmas'))->async('asyncGetElemento'),



            ];
        } else {
            return [
                Layout::rows([
                    Label::make('titulo')
                        ->title(__('No hay elementos para mostrar')),
                ])

            ];
        }
    }


    public function importar(Request $request, Ubicacion $ubicacion)
    {
        // dd($ubicacion->id, $request->get('equipo_id'));

        //cargar el archivo , falta validarlo para evitar errores

        if ($request->archivo->isValid()) {
            $fileName = $request->archivo->getClientOriginalName();
            $filePath = '/public/' . $request->archivo->storeAs('uploads', $fileName, 'public');
        }
        //borrar todos los emenetos y alarmas en cascada de la ubicacion elegida y equipo elegido
        Elemento::where('ubicacion_id', $ubicacion->id)
            ->where('equipo_id', $request->get('equipo_id'))
            ->delete();


        //leer las hojas y crear lon nuevos elementos en la DB 



        $Import = new LibroAlarmasImport();

        $ts = Excel::import($Import, $filePath);


        $failures = [];
        // Return an import object for every sheet

        foreach ($Import->getSheetNames() as $index => $sheetName) {
            $elemento = Elemento::create([
                'elemento' => $sheetName,
                'ubicacion_id' => $ubicacion->id,
                'equipo_id' => $request->get('equipo_id'),

            ]);

            $importHoja = new ImportHoja($elemento->id);

            $importHoja->onlySheets($sheetName);

            Excel::import($importHoja, $filePath);
        }







        Toast::info(__('Alarmas importadas a la DB!.'));
    }





    public function asyncGetElemento(Elemento $elemento): iterable
    {

        return [
            'elemento' => $elemento,
        ];
    }
}
