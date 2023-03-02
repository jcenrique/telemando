<?php

namespace App\Orchid\Resources;

use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class TensionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model =\App\Models\Tension::class;
    public static function permission(): ?string
    {
        return 'resource-tensiones';
    }
    public static function singularLabel(): string
    {
        return __('Tensión');
    }
    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('tension')
            ->title(__('Tensión'))
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
           // TD::make('id'),
           TD::make('tension',__('Tensión'))->sort(),
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

            Sight::make('tension'),
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
        return 'Tensiones nominales de los suministros';
    }
    public static function label(): string
    {
        return __('Tensiones');
    }

    public static function icon(): string
    {
        return 'bolt-lightning';
    }
}
