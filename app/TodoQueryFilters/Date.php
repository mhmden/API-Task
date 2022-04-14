<?php

namespace App\TodoQueryFilters;

class Date extends Filter
{
    protected function applyFilter($builder){

        $from = request('from');
        $to = request('to');
        return $builder->whereBetween('created_at', [$from, $to]);

    }
}
