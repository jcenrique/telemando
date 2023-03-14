<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Exports\VehiculosExport;
use App\Models\Kilometraje;
use App\Models\Vehiculo;
use App\Orchid\Filters\BajaVehiculoFilter;
use App\Orchid\Filters\MatriculaFilter;
use App\Orchid\Filters\WithTrashed;
use App\Orchid\Layouts\Vehiculos\VehiculoLayautTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VehiculoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public $vehiculos;
    public $roles_permitidos;
    public $exportData;
    private $withTrashed = false;
    public function query(): iterable


    {
        $this->roles_permitidos = Auth::user()->getRoles()->whereIn('slug', ['flota', 'admin'])->count();
        $user_id =  Auth::user()->id;
        $this->vehiculos = Vehiculo::with('repostajes', 'kilometrajes')->filters([MatriculaFilter::class, WithTrashed::class])->paginate();

        if (count($this->vehiculos) != 0) {
            $this->withTrashed =  $this->vehiculos->first()->trashed();
        }
        return [
            'vehiculos' =>  $this->vehiculos,
            'withTrashed' => $this->withTrashed,
            'exporData' => $this->exportData,
        ];
    }
    public function permission(): ?iterable
    {
        return [
            'vehiculos'
        ];
    }
    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Vehículos');
    }

    public function description(): ?string
    {
        return __('Flota de vehículos de ETS-RFV');
    }
    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Crear'))
                ->icon('pencil')

                ->route('platform.vehiculo.create'),


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

        //    dd($this->query()['vehiculos']);

        return [

            Layout::selection([MatriculaFilter::class,  WithTrashed::class]),

            new VehiculoLayautTable(),

            Layout::modal('registro_kilometros', [
                Layout::rows([
                    DateTimer::make('fecha')
                        ->title(__('Fecha anotación'))
                        ->required()
                        ->format('Y-m-d'),
                        

                    Input::make('kilometraje')
                        ->title(__('Kilometros'))
                        ->type('number')
                        ->required()
                        ->placeholder(__('Introduce los kilometros')),
                ])


            ])->title(__('Registro kilometraje'))
            //  VehiculoLayautTable::class
        ];
    }
    public function remove(Request $request): void
    {
        Vehiculo::findOrFail($request->get('id'))->forceDelete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }

    public function baja(Request $request): void
    {


        $vehiculo = Vehiculo::find($request->get('id'));
        $vehiculo->fecha_baja = Carbon::now()->format('Y-m-d');
        $vehiculo->save();
        $vehiculo->delete();
        Toast::info(__('El vehiculo ha sido ha sido dado de baja con éxito'));
    }
    public function alta(Request $request): void
    {

        $vehiculo = Vehiculo::withTrashed()
            ->where('id', $request->get('id'))->restore();

        $vehiculo = Vehiculo::find($request->get('id'));

        $vehiculo->fecha_baja = null;
        $vehiculo->save();

        Toast::info(__('El vehiculo ha sido ha sido dado de alta con éxito'));
    }

    public function export()
    {

        $elementos_exportación = Vehiculo::filters()->withTrashed()->get();



        return Excel::download(new VehiculosExport($elementos_exportación), 'vehiculos.xlsx');
    }

    public function anotarKilometros(Request $request, $id): void
    {
        $request->validate([
            'fecha' =>'required',
            'kilometraje' =>[ 'required' , 'numeric'],
        ]);
        //anotar los kilometros si la fecha es mayor que la ultima y si los kilometros son mayores

        $kilometraje_max = Kilometraje::where('vehiculo_id', $id)->get()->max('kilometraje');
        $fecha_max = is_null(Kilometraje::where('vehiculo_id', $id)->get()->max('fecha')) ?  Carbon::createFromFormat('Y-m-d', '2000-01-01') :
            Carbon::createFromFormat('Y-m-d', Kilometraje::where('vehiculo_id', $id)->get()->max('fecha'));
        $kilometros = $request->get('kilometraje');
        $fecha = Carbon::createFromFormat('Y-m-d', $request->get('fecha'));
        if (($kilometraje_max > intval($kilometros)) || ($fecha_max->gt($fecha))) {
            Alert::warning(__('La fecha o los kilometros son inferiores a la última anotación'));
            return;
        } else {
            Kilometraje::create([
                'vehiculo_id' => $id,
                'fecha' => $fecha,
                'kilometraje' => $kilometros
            ]);


            Toast::info(__('Datos registrados'));
            return;
        }
    }
   
}
