<?php

namespace App\QueryFilters;

class Category extends Filter
{

    protected function applyFilters($builder, $value)
    {
        return $builder->where('active',request($this->filterName()));
    }

}