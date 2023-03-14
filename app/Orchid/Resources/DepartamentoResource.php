<?php

namespace App\Orchid\Resources;

use App\Models\User;
use App\Rules\Uppercase;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Illuminate\Validation\Rule;

class DepartamentoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static function permission(): ?string
    {
        return 'resource-departamentos';
    }
    public static $model = \App\Models\Departamento::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('departamento')
            ->title(__('Departamento'))
            ->required()
            
            ->help(__('Introduzca el nombre del departamento')),

          
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
          //  TD::make('id'),
            TD::make('departamento',__('Departamento'))->sort(),
          
            TD::make('created_at', __('Date of creation'))
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', __('Update date'))
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
            Sight::make('departamento',__('Departamento')),
         
             

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    public function rules(Model $model): array
    {
        return [
            'departamento' => [
                'required',
                new Uppercase,
                Rule::unique(self::$model, 'departamento')->ignore($model),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'departamento.required' => __('El campo departamento  no puede estar vacío'),
            
            'departamento.unique' => __('El campo departamento no puede estar repetido.'),
            
        ];
    }

    public static function icon(): string
    {
        return 'people-roof';
    }
}
