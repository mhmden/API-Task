<?php
namespace App\TodoQueryFilters;


class Tags extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->whereHas('tags', function ($q){
            $q->whereIn('tag_id', request($this->filterName()));
        });
    }
}
