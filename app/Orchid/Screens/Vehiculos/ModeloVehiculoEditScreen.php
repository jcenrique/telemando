<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Marcavehiculo;
use App\Models\Modelovehiculo;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ModeloVehiculoEditScreen extends Screen
{
    public $modelo;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Modelovehiculo $modelo): iterable
    {
        return [
            'modelo' => $modelo
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->modelo->exists ? __( 'Edita modelo' ): ('Crear nuevo modelo');
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
            ->canSee(!$this->modelo->exists),

        Button::make('Update')
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->modelo->exists),

        Button::make('Remove')
            ->icon('trash')
            ->method('remove')
            ->canSee($this->modelo->exists),
        
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
                Input::make('modelo.modelo')
                ->required()
                    ->title(__('Modelo'))
                    ->help(__('Introduzca el nombre del nuevo modelo de vehículo')),
              
                    
                    Select::make('modelo.marcavehiculo_id')
                    ->help(__('Seleccione la marca a la que pertenece el nuevo modelo de vehículo'))
                    ->required()
                    ->empty()
                    ->fromModel(Marcavehiculo::class,'marca')
                   ->applyScope('ordered')
                    ->title('Marca'),

               
                    
                                    
            ])
        ];
    }


    public function createOrUpdate(Modelovehiculo $modelo, Request $request)
    {
      
        $modelo->fill($request->get('modelo'))->save();
        $this->modelo=$modelo;
        Toast::info($this->modelo->exists ? __('Registro modificado con éxito.'):__('Registro creado con éxito.'));

        return redirect()->route('platform.vehiculos.modelos');
    }

    /**
     * @param Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Modelovehiculo $modelo)
    {
        $modelo->delete();

        Toast::info(__('Registro eliminado con éxito.'));

        return redirect()->route('platform.vehiculos.modelos');
    }
}
