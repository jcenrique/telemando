<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Tipovehiculo;
use App\Orchid\Layouts\Vehiculos\TipoVehiculoLayoutTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TipoVehiculoListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tipos' => Tipovehiculo::filters()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tipos de vehiculos';
    }
    public function description(): ?string
    {
        return __('Tipos de vehiculos usados por el personal de ETS');
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
            ->route('platform.vehiculos.tipo.create'),
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
            TipoVehiculoLayoutTable::class
        ];
    }
    

    public function remove(Request $request): void
    {
        Tipovehiculo::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }
}
