<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Kilometraje;
use Illuminate\Http\Request;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class KilometrosVehiculosEditScreen extends Screen
{
    public $kilometraje;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Kilometraje $kilometraje): iterable
    {
        return [
            'kilometraje' => $kilometraje,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Editar kilometros vehículo';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->kilometraje->exists),

        Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->kilometraje->exists),
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
            Layout::rows([
                Input::make('kilometraje.kilometraje')
                    ->required()
                    ->title(__('Kilometraje'))
                    ->type('number')
                    ->placeholder(__('Introduce los kilometros')),
                DateTimer::make('kilometraje.fecha')
                    ->title(__('Fecha'))
                    ->placeholder(__('Introduce la fecha'))->format('Y-m-d')->required(),
            ])
           
        
    
        ];
    }

    public function createOrUpdate(Kilometraje $kilometraje, Request $request)
    {


        $kilometraje->fill($request->get('kilometraje'))->save();
        $this->kilometraje = $kilometraje;
        $vehiculo_id =  $kilometraje->vehiculo_id;
        Toast::info($this->kilometraje->exists ? __('Registro modificado con éxito.') : __('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculo.edit',  $vehiculo_id);
    }


    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Kilometraje $kilometraje)
    {
        $vehiculo_id =  $kilometraje->vehiculo_id;
        $kilometraje->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculo.edit',  $vehiculo_id);
    }
}
