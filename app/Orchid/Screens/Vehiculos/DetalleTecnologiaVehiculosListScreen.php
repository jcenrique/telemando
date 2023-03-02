<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Detalletecnologia;
use App\Orchid\Layouts\Vehiculos\DetalleTecnologiaVehiculosLayautTable;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class DetalleTecnologiaVehiculosListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'detalles' => Detalletecnologia::filters()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Detalle Tecnologías';
    }
    public function description(): ?string
{
    return __('Subclasificación de las diferentes clases de tecnologías');
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
        ->route('platform.vehiculos.detalle-tecnologias.create'),
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
            DetalleTecnologiaVehiculosLayautTable::class,
        ];
    }

    public function remove(Request $request): void
    {
        Detalletecnologia::findOrFail($request->get('id'))->delete();

        Toast::info(__('El registro ha sido ha sido eliminado con éxito'));
    }
}
