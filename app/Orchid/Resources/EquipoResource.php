<?php

namespace App\Orchid\Resources;

use App\Rules\Uppercase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Orchid\Crud\Filters\DefaultSorted;
use Orchid\Crud\Resource;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class EquipoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Equipo::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('equipo')
                ->title(__('Tipo equipo'))
                ->required()
                ->help(__('Introduzca el nombre descriptivo del tipo de equipamiento'))

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

            TD::make('equipo')
                ->sort(),

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
            Sight::make('equipo'),
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
            new DefaultSorted('equipo', 'asc'),
        ];
    }

    /**
     * Get the validation rules that apply to save/update.
     *
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'equipo' => [
                'required',
                new Uppercase,
                Rule::unique(self::$model, 'equipo')->ignore($model),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'equipo.required' => __('El campo equipo  no puede estar vacío'),
            
            'equipo.unique' => __('El campo equipo no puede estar repetido.'),
            
        ];
    }
    public static function icon(): string
    {
        return 'modules';
    }
   
}
