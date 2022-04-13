<?php

namespace App\TodoQueryFilters;

class Files extends Filter {
    protected function applyFilter($builder){
        return $builder->whereHas($this->filterName(), function($q){
            $q->whereIn('name', request($this->filterName()));
        });
    }
}