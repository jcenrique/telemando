<?php

namespace App\Orchid\Filters;

use App\Models\Tipovehiculo;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class TipoVehiculoFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Tipo Vehículo');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('tipovehiculo_id', $this->request->get('tipovehiculo_id'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
       return [
        Select::make('tipovehiculo_id')
        ->fromModel(Tipovehiculo::class, 'tipo', 'id')
        ->empty()
        ->value($this->request->get('tipovehiculo_id'))
        ->title(__('Tipo vehículo')),
       ];
    }

    public function value(): string
    {
   

        return $this->name().': '.Tipovehiculo::where('id', $this->request->get('tipovehiculo_id'))->first()->tipo;
       
    }
}
