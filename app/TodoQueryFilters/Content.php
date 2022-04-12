<?php

namespace App\TodoQueryFilters;

class Content extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where($this->filterName(), 'like', '%'.request($this->filterName()).'%');   
    }
}
