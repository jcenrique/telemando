<?php

namespace App\Orchid\Filters;

use App\Models\Zona;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ZonaQueryFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Zonas');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['zona' , 'ubicacion','nombre_zona'];
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

       
        return $builder->where('zona_id', $this->request->get('zona'));
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('zona')
            ->empty()
                ->fromModel(Zona::class,'zona')
                ->value($this->request->get('zona'))
                ->help(__('Seleccione una zona'))
                ->title('Zonas')

        ];
    }
    public function value(): string
    {
   

        return $this->name().': '.Zona::where('id', $this->request->get('zona'))->first()->zona;
       
    }

    
}
