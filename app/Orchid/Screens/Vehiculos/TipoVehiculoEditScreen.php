<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Tipovehiculo;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TipoVehiculoEditScreen extends Screen
{
    public $tipo;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Tipovehiculo $tipo): iterable
    {


        return [
            'tipo' => $tipo
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->tipo->exists ? __( 'Edita tipo vehículo' ): ('Crear nuevo tipo vehículo');
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
        ->canSee(!$this->tipo->exists),

    Button::make('Update')
        ->icon('note')
        ->method('createOrUpdate')
        ->canSee($this->tipo->exists),

    Button::make('Remove')
        ->icon('trash')
        ->method('remove')
        ->canSee($this->tipo->exists),
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
                Input::make('tipo.tipo')
                ->required()
                    ->title(__('Tipo vehículo'))
                    ->placeholder(__('Introduzca el nombre de un tipo de vehículos'))
                                    ->help(__('Especificar tipos o clases de vehiculos para cubrir las necesidades en ETS.')),
            ])
        ];
    }

    public function createOrUpdate(Tipovehiculo $tipo, Request $request)
    {

        $request->validate([
           
            'tipo.tipo' => [
                'required',
                Rule::unique('tipovehiculos', 'tipo')->ignore($tipo)
            ]
        ]);

        $tipo->fill($request->get('tipo'))->save();
        $this->tipo=$tipo;
        Toast::info($this->tipo->exists ? __('Registro modificado con éxito.'):__('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos.tipos');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Tipovehiculo $tipo)
    {
        $tipo->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.tipos');
    }
}
