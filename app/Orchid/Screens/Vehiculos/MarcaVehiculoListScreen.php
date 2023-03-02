<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Marcavehiculo;
use App\Orchid\Layouts\Vehiculos\MarcavehiculoLayoutTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class MarcaVehiculoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'marcas' => Marcavehiculo::with('modelos')->filters()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Marcas de vehículos';
    }
    public function description(): ?string
    {
        return __('Listado de las marcas de los vehículos de ETS');
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
            ->route('platform.vehiculos.marca.create'),

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
            MarcavehiculoLayoutTable::class
        ];
    }

    public function remove(Request $request): void
    {
        Marcavehiculo::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }
}
