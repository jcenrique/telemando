<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Tecnologia;
use App\Orchid\Layouts\Vehiculos\TecnologiaVehiculosLayautTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TecnologiaVehiculosListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tecnologias' => Tecnologia::filters()->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Tecnologias Vehículos');
    }
public function description(): ?string
{
    return __('Tipos de tecnologías diferentes que utilizan los vehículos');
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
            ->route('platform.vehiculos.tecnologia.create'),

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
            TecnologiaVehiculosLayautTable::class,
        ];
    }

    public function remove(Request $request): void
    {
        Tecnologia::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }
}
