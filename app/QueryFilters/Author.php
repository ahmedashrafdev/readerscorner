<?php

namespace App\QueryFilters;

class Author extends Filter
{

    protected function applyFilters($builder, $value)
    {
        return $builder->where('active',request($this->filterName()));
    }

}