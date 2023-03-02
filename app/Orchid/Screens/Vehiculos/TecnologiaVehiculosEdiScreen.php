<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Tecnologia;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TecnologiaVehiculosEdiScreen extends Screen
{

    public $tecnologia;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Tecnologia $tecnologia): iterable
    {
        return [
            'tecnologia' => $tecnologia,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->tecnologia->exists ? __( 'Edita tecnología vehículo' ): ('Crear nuevo tecnología vehículo');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Crear')
            ->icon('pencil')
            ->method('createOrUpdate')
            ->canSee(!$this->tecnologia->exists),
    
        Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->tecnologia->exists),
    
        Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->tecnologia->exists),
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
                Input::make('tecnologia.tecnologia')
                    ->title(__('Tecnología vehículo'))
                    ->placeholder(__('Introduzca el nombre de una Tecnología de vehículos'))
                                    ->help(__('Especificar las Tecnologías disponibles en el mercado para clasificar los vehículos.')),
            ])
        ];
    }

    public function createOrUpdate(Tecnologia $tecnologia, Request $request)
    {
        $request->validate([
            'tecnologia.tecnologia' => new Uppercase,
        ]);

        
        $tecnologia->fill($request->get('tecnologia'))->save();
        $this->tecnologia=$tecnologia;
        Toast::info($this->tecnologia->exists ? __('Registro modificado con éxito.'):__('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos.tecnologias');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Tecnologia $tecnologia)
    {
        $tecnologia->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.tipos');
    }
}
