<?php
namespace App\TodoQueryFilters;

use Closure;

class Tag {

    public function handle($request, Closure $next){
            if (! request()->has('tags')){
                return $next($request);
            }
            $builder = $next($request);
            return $builder->has('tags');

    }

}


// class Tag extends Filter
// {
//     protected function applyFilter($builder)
//     {
//         return $builder->has('tags');
//     }
// }
