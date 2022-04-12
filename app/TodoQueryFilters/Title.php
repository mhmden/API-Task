<?php

namespace App\TodoQueryFilters;


class Title extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->where($this->filterName(), request($this->filterName()));
    }
}
