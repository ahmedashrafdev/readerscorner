<?php

namespace App\QueryFilters;

class Price extends Filter
{

    protected function applyFilters($builder, $value)
    {
        return $builder->where('active',request($this->filterName()));
    }

}