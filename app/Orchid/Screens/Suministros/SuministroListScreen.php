<?php

namespace App\Orchid\Screens\Suministros;

use App\Exports\SuministrosExport;
use App\Imports\SuministroImport;
use App\Models\Suministro;
use App\Orchid\Filters\WithTrashed;
use App\Orchid\Filters\ZonaQueryFilter;
use App\Orchid\Layouts\Suministros\PoblacionFiltersLayout;
use App\Orchid\Layouts\Suministros\SuministroTableLayout;
use App\Orchid\Layouts\Telemando\UbicacionFiltersLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;

class SuministroListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'suministros' =>  Suministro::filters([ZonaQueryFilter::class, WithTrashed::class])->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Suministros de energía';
    }
    public function description(): ?string
    {
        return __('Listado completo de los suministros de energía instalaciones ETS');
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Link::make(__('Crear nuevo'))
                ->icon('pencil')
                ->route('platform.suministro.create'),

            ModalToggle::make(__('Importar'))
                ->modal('abrirFicheroExcel')
                ->method('importar')

                ->icon('upload'),

           
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
        return [


            Layout::selection([ WithTrashed::class]),
            SuministroTableLayout::class,
            Layout::modal('abrirFicheroExcel', [
                Layout::rows([



                    Input::make('archivo')->type('file')
                        ->title(__('Selecciona un archivo Excel de suministros electricos'))
                        ->required()


                ])

            ])->title(__('Cargar fichero Excel de suministros')),
        ];
    }

    public function importar(Request $request)
    {
        // dd($ubicacion->id, $request->get('equipo_id'));

        //borrar registros anteriores

        //cargar el archivo , falta validarlo para evitar errores

        if ($request->archivo->isValid()) {
            $fileName = $request->archivo->getClientOriginalName();
            $filePath = '/public/' . $request->archivo->storeAs('uploads', $fileName, 'public');
        }
        //borrar todos los emenetos y alarmas en cascada de la ubicacion elegida y equipo elegido


        //leer las hojas y crear lon nuevos elementos en la DB 



        $importHoja = new SuministroImport();


        Excel::import($importHoja, $filePath);


        foreach ($importHoja->failures() as $failure) {
            $failure->row(); // row that went wrong
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.
        }





        Toast::info(__('Suministros importados a la DB!.'));
    }

    public function export() 
    {
    
        $elementos_exportación = Suministro::filters()->withTrashed()->get();
    $date= Suministro::get('updated_at')->sortByDesc('updated_at')->first()->updated_at;
    $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)
                                    ->format('Ymd H,i');

        return Excel::download(new SuministrosExport($elementos_exportación), $newDate . '_suministros.xlsx');
    }

}
