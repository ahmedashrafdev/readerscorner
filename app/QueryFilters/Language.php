<?php

namespace App\QueryFilters;

class Language extends Filter
{

    protected function applyFilters($builder, $value)
    {
        return $builder->where('active',request($this->filterName()));
    }

}