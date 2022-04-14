<?php

namespace App\TodoQueryFilters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($request, Closure $next) 
    {
        return (request()->has($this->filterName())) ? $this->applyFilter($next($request)): $next($request);
    }

    protected abstract function applyFilter($builder);

    protected function filterName(){
        return Str::snake(class_basename($this)); // 
    }
}
