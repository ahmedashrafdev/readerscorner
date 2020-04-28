<?php

namespace App\QueryFilters;

class Age extends Filter
{

    protected function applyFilters($builder , $value)
    {
        return $builder->with('ages')->whereHas('ages', function ($query)  use ($value){
            $query->where('slug', $value);
        });
    }

}