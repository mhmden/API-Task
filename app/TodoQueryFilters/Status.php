<?php

namespace App\TodoQueryFilters;

use Closure;

class Status
{

    public function handle($request, \Closure $next)
    {
        if (!request()->has('status')) {
            return $next($request);
        }
        $builder = $next($request);
        return $builder->where('status_id', request('status'));
    }
}
