<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Marcavehiculo;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class MarcaVehiculoEditScreen extends Screen
{
    
    public $marca;
    
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Marcavehiculo $marca): iterable
    {
        return [
            'marca' => $marca
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->marca->exists ? __( 'Edita marca' ): ('Crear nueva marca');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Crear Marca')
            ->icon('pencil')
            ->method('createOrUpdate')
            ->canSee(!$this->marca->exists),

        Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->marca->exists),

        Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->marca->exists),
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
                Input::make('marca.marca')
                    ->title(__('Marca'))
                    ->placeholder(__('Introduzca el nombre de una marca de vehículos'))
                                    ->help(__('Especificar marcas que esten disponibles en ETS.')),
            ])
                                ];

    }
    

    public function createOrUpdate(Marcavehiculo $marca, Request $request)
    {

        $request->validate([
            'marca.marca' => new Uppercase,
            
        ]);
        $marca->fill($request->get('marca'))->save();
        $this->marca=$marca;
        Toast::info($this->marca->exists ? __('Registro modificado con éxito.'):__('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos.marcas');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Marcavehiculo $marca)
    {
        $marca->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.marcas');
    }
}
