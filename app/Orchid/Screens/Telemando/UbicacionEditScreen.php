<?php

namespace App\Orchid\Screens\Telemando;

use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\Zona;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;

class UbicacionEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */

    public $ubicacion;
    public function query(Ubicacion $ubicacion): iterable
    {
       
        return [
            'ubicacion' => $ubicacion
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return  $this->ubicacion->exists ? __('Editar ubicación'): __('Crear ubicación') ;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {

        return [
            Button::make(__('Crear ubicación'))
            ->icon('pencil')
            ->method('createOrUpdate')
            ->canSee(!$this->ubicacion->exists),

        Button::make(__('Update'))
            ->icon('note')
            ->method('createOrUpdate')
            ->canSee($this->ubicacion->exists),

        Button::make(__('Remove'))
            ->icon('trash')
            ->method('remove')
            ->canSee($this->ubicacion->exists),
        
        Link::make(__('Añadir elementos'))
            ->icon('plus')
            ->route('platform.elementos.edit',[$this->ubicacion])
            ->canSee($this->ubicacion->exists),
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
                Input::make('ubicacion.ubicacion')
                    ->title(__('Ubicación'))
                   ->required()
                    ->help('Introduzca el nombre de la ubicación.'),

            
                Relation::make('ubicacion.zona_id')
                    ->title('Zona')
                    ->required()
                    ->help(__('Seleccione una zona para situar la ubicación'))
                    ->fromModel(Zona::class, 'zona'),

                    Relation::make('ubicacion.equipos')
                    //->required()
                        ->multiple()
                        ->fromModel(Equipo::class,'equipo', 'id')
                        ->title(__('Equipamientos disponibles en la ubicación'))
                        ->help(__('Seleccione el equipo o equipos disponibles en la ubicación')),
            ]),
            
        ];
    }

    public function createOrUpdate(Ubicacion $ubicacion, Request $request)
    {
       // dd($request->get('ubicacion')['equipos']);
        $ubicacion->fill($request->get('ubicacion'))->save();
        $this->ubicacion = $ubicacion;
        
        
        $this->ubicacion->equipos()->detach();
        

        $this->ubicacion->equipos()->attach($request->get('ubicacion')['equipos']);
       // $ubicacion->save();

        Toast::info($this->ubicacion->exists ?__('Actualizada la ubicación con éxito'): __('Creada la ubicación con éxito'));

        return redirect()->route('platform.ubicaciones');
    }

    /**
     * @param Post $ubicacion
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Ubicacion $ubicacion)
    {
        $ubicacion->delete();

        Toast::info(__('Eliminada la ubicación con éxito'));

        return redirect()->route('platform.ubicaciones');
    }
}
