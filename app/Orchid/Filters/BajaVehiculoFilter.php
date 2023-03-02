<?php

namespace App\Orchid\Filters;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class BajaVehiculoFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Estado');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['estado'];
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
      
       if ($this->request->get('estado') =='ALTA' ) {
            return $builder->where('fecha_baja', null);
       }else{
            return $builder->where('fecha_baja','!=', null);
       }
        
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return[
        Select::make('estado')
            ->empty()
            
            ->options([ 'ALTA' =>__('ALTA') , 'BAJA' => __('BAJA') ])
            ->value($this->request->get('estado'))
           
            ->title(__('Estado')),
       ];
    }
 
}
