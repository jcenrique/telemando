<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Modelovehiculo;
use App\Orchid\Layouts\Vehiculos\ModeloVehiculoLayoutTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ModeloVehiculoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'modelos' => Modelovehiculo::with('marca')->filters()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Lista de modelos';
    }


public function description(): ?string
{
    return __('Listado de los modelos de  vehículos de ETS');
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
            ->route('platform.vehiculos.modelo.create'),
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
            ModeloVehiculoLayoutTable::class
        ];
    }

    public function remove(Request $request): void
    {
        Modelovehiculo::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }
  
}
