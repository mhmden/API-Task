<?php

namespace App\TodoQueryFilters;

class Users extends Filter {
    protected function applyFilter($builder)
    {
        return $builder->whereHas('users', function ($q){
            $q->whereIn('user_id', request($this->filterName()));
        });
    } 
}