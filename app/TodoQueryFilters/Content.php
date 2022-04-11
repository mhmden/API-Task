<?php

namespace App\TodoQueryFilters;

use Closure;

class Content
{


    public function handle($request, \Closure $next)
    {

        if( !request()->has('content')){
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('content', 'like', '%'.request('content').'%');
    }
}
