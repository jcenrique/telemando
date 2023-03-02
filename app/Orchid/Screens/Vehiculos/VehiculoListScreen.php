<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Vehiculo;
use App\Orchid\Filters\BajaVehiculoFilter;
use App\Orchid\Filters\MatriculaFilter;

use App\Orchid\Layouts\Vehiculos\VehiculoLayautTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VehiculoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'vehiculos' => Vehiculo::with('kilometrajes')->filters([MatriculaFilter::class, BajaVehiculoFilter::class])->paginate()
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
            Layout::selection([MatriculaFilter::class, BajaVehiculoFilter::class]),
         
            
            VehiculoLayautTable::class
        ];
    }
    public function remove(Request $request): void
    {
        Vehiculo::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }

    public function baja(Request $request): void
    {
        $vehiculo= Vehiculo::find($request->get('id'));
        $vehiculo->fecha_baja = Carbon::now()->format('Y-m-d');
        $vehiculo->save();
        Toast::info(__('El vehiculo ha sido ha sido dado de baja con éxito'));
    }
    public function alta(Request $request): void
    {
        $vehiculo= Vehiculo::find($request->get('id'));
        $vehiculo->fecha_baja = null;
        $vehiculo->save();

        Toast::info(__('El vehiculo ha sido ha sido dado de alta con éxito'));
    }
}
