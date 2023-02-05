<?php

namespace App\Orchid\Screens\Telemando;

use App\Models\Ubicacion;
use App\Models\Zona;
use App\Orchid\Filters\ZonaQueryFilter;
use App\Orchid\Layouts\Telemando\UbicacionFiltersLayout;
use App\Orchid\Layouts\Telemando\UbicacionTableLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UbicacionListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'ubicaciones' => Ubicacion::with(['equipos','elementos'])->filters([ZonaQueryFilter::class])->defaultSort('ubicacion')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Lista de ubicaciones');
    }

    public function description(): ?string
    {
        return __('Listado completo de ubicaciones');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Crear nueva'))
            ->icon('pencil')
            ->route('platform.ubicacion.edit')

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
            UbicacionFiltersLayout::class,

            UbicacionTableLayout::class,
        ];
    }

    public function remove(Request $request): void
    {
        Ubicacion::findOrFail($request->get('id'))->delete();

        Toast::info(__('La ubicación ha sido eliminada'));
    }
}
