<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Detalletecnologia;
use App\Models\Tecnologia;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DetalleTecnologiaVehiculosEdiScreen extends Screen
{
    public $detalle;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Detalletecnologia $detalle): iterable
    {
        return [
            'detalle' => $detalle
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->detalle->exists ? __( 'Editar detalle tecnología' ): ('Crear nuevo detalle tecnología');
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
            ->canSee(!$this->detalle->exists),

        Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->detalle->exists),

        Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->detalle->exists),
        
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
                Input::make('detalle.detalle')
                ->required()
                    ->title(__('Sub-clasificación de tecnologías'))
                  ->placeholder(__('Introduzca el nombre de la sub-clase de tecnología')),
                
                Relation::make('detalle.tecnologia_id')
                ->required()
                    ->fromModel(Tecnologia::class,'tecnologia')
                    ->title('Tecnología'),

            ])
           
        ];
    }

    public function createOrUpdate(Detalletecnologia $detalle, Request $request)
    {
        $request->validate([
            

            'detalle.detalle' => [
                new Uppercase,
                'required',
                Rule::unique('detalletecnologias', 'detalle')->ignore($detalle)
            ],
           
        ]);
        

        $detalle->fill($request->get('detalle'))->save();
        $this->detalle=$detalle;
        Toast::info($this->detalle->exists ? __('Registro modificado con éxito.'):__('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos.detalles-tecnologias');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Detalletecnologia $detalle)
    {
        $detalle->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.detalles-tecnologias');
    }
}
