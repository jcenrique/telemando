<?php

namespace App\Orchid\Resources;

use App\Models\Relacion;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class RelacionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model =\App\Models\Relacion::class;

    public static function permission(): ?string
    {
        return 'resource-relaciones';
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('relacion')
             ->title(__('Relación'))
             ->required()
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
            //TD::make('id'),
            TD::make('relacion',__('Relación TI'))->sort(),

            TD::make('created_at',__( 'Date of creation'))
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
            Sight::make('relacion'),
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

    public static function description(): ?string
    {
        return 'Relaciones de transformación instaladas en los suministros';
    }
    public static function label(): string
    {
        return __('Relaciones TI');
    }

    public static function icon(): string
    {
        return 'atom';
    }
    public static function singularLabel(): string
    {
        return __('Relación');
    }
}