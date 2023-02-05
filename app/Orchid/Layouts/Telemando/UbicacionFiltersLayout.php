<?php

namespace App\Orchid\Layouts\Telemando;

use App\Orchid\Filters\ZonaQueryFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class UbicacionFiltersLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ZonaQueryFilter::class,
        ];
    }
}
