<?php

namespace App\TodoQueryFilters;

use Closure;

class Title
{

    // TODO Watch pipeline vidoe till the end
    public function handle($request, \Closure $next)
    {

        if( !request()->has('title')){
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('title', request('title'));
    }
}
