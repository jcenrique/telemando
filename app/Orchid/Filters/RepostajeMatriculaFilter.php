<?php

namespace App\Orchid\Filters;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class RepostajeMatriculaFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Matrícula');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['vehiculo_id'];
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
        return $builder->where('vehiculo_id', $this->request->get('vehiculo_id') );
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('vehiculo_id')
           ->empty()
        
           ->fromModel(Vehiculo::class,'matricula','id')
       
            ->title('Matrícula')
    
        ];
    }

    public function value(): string
    {
        return $this->name().': '. Vehiculo::find( $this->request->get('vehiculo_id'))->matricula;
    }
}
