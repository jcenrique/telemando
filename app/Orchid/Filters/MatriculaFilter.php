<?php

namespace App\Orchid\Filters;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

use function PHPUnit\Framework\isNull;

class MatriculaFilter extends Filter
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
        return ['id'];
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
        return $builder->where('id', $this->request->get('id') );
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('id')
            ->empty()
        
           ->fromModel(Vehiculo::class,'matricula','id')
       
            ->title('Matrícula')
    
        ];
    }

    public function value(): string
    {
     
        if(is_null( Vehiculo::find( $this->request->get('id')))){
            return $this->name().': '. __('No existe');
        }else{
            return $this->name().': '. Vehiculo::find( $this->request->get('id'))->matricula;
        }
       
    }
}
