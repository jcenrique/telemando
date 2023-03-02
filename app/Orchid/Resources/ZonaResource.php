<?php

namespace App\Orchid\Resources;

use App\Models\Equipo;
use App\Rules\Uppercase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ZonaResource extends Resource
{
    public static function permission(): ?string
    {
        return 'resource-zonas';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    
    public static $model = \App\Models\Zona::class;
  
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('zona')
                ->title(__('Zona'))
                ->required()
                ->help(__('Introduzca el nombre de una zona geográfica.')),
           
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
          
            TD::make('zona')->sort(),

            TD::make('created_at', 'Date of creation')
            ->defaultHidden(true)
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
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
            Sight::make('zona'),
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
           // new DefaultSorted('equipo', 'asc'),
        ];
    }

    public function rules(Model $model): array
    {
        return [
            'zona' => [
                'required',
                new Uppercase,
                Rule::unique(self::$model, 'zona')->ignore($model),
            ],
        ];

    }
    
    public function with(): array
    {
        return ['ubicaciones'];
    }

    public static function icon(): string
    {
        return 'globe';
    }
}
