<?php

namespace App\Orchid\Resources;

use App\Models\Equipo;
use App\Models\Zona;
use App\Orchid\Actions\DeleteAction;
use App\Orchid\Actions\ImportUbicacionesAction;
use App\Orchid\Filters\ZonaQueryFilter;
use App\Rules\Uppercase;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Crud\Requests\ActionRequest;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Sight;

class UbicacionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Ubicacion::class;

    public static function description(): ?string
{
    return __('Localización de las diferentes ubicaciones de los diferentes tipos de equipos');
}
    public static function label(): string
    {
        return __('Ubicaciones');
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
       
        return [
            Input::make('ubicacion')
                ->required()
                ->title(__('Ubicación')),
            
                Input::make('comentario')
                ->required()
                ->title('Comentario')
                ->value('OK'),
            
                Relation::make('zona_id')
                    ->title('Zona')
                   ->required()
                    ->fromModel(Zona::class, 'zona')
                   
                    ->help(__('Seleccione la zona a la que pertenece la ubicación')),

                Relation::make('equipos')
                //->required()
                    ->multiple()
                    ->fromModel(Equipo::class,'equipo', 'id')
                    ->title(__('Equipamientos disponibles en la ubicación'))
                    ->help(__('Seleccione el equipo o equipos disponibles en la ubicación')),
              
               
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {


        return [


            TD::make('ubicacion')
                ->filter()
                ->sort(),
            TD::make('comentario'),
            TD::make('zona_id', __('Zona'))
                ->sort()

                ->render(function ($model) {
                    return Zona::find($model->zona_id)->zona;
                }),

            TD::make('equipos', __('Equipos'))
              

                ->render(function ($model) {
                    $equipos = [];
                    foreach ($model->equipos as $key => $equipo) {
                        $equipos[] = $equipo->equipo;
                    }
                    return implode(' <BR> ', $equipos) ;
                }),


          
                

            TD::make('created_at', __('Date of creation'))
            ->defaultHidden(true)
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', __('Update date'))
            ->defaultHidden(true)
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('ubicacion'),
            Sight::make('comentario'),
            Sight::make('zona_id', __('Zona'))
            ->render(function ($model) {
                return Zona::find($model->zona_id)->zona;
            }),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
           ZonaQueryFilter::class
        ];
    }
    
    public function actions(): array
    {
        return [
           DeleteAction::class,
        ];
    }


    public function rules(Model $model): array
    {
       
        return [
            'ubicacion' => [
                'required',
                new Uppercase,
                Rule::unique(self::$model, 'ubicacion')->ignore($model),
            ],
            'comentario' => 'required',
            
            'equipos' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'ubicacion.required' => __('El campo ubicación  no puede estar vacío'),
            'comentario.required' => __('El campo comentario  no puede estar vacío'),
            'ubicacion.unique' => __('El campo ubicación no puede estar repetido.'),
            'equipos.required' => __('El campo de equipamientos  no puede estar vacío'),
        ];
    }

    public function with(): array
    {
        return [
            'zona',
            'equipos'
        ];
    }

    public function onSave(ResourceRequest $request, Model $model)
{
       
        $model->ubicacion = $request->get('ubicacion');
        $model->comentario = $request->get('comentario');
        $model->zona_id = $request->get('zona_id');
        $model->equipos()->detach();
        $model->save();

        $model->equipos()->attach($request->get('equipos'));



}

public static function icon(): string
{
    return 'city';
}

}
