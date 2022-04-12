<?php

namespace App\TodoQueryFilters;


class Status extends Filter
{
    protected function applyFilter($builder){
        return $builder->where('status_id' , request($this->filterName()));
    }
}
