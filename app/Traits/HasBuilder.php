<?php
namespace App\Traits;

use Exception;

trait HasBuilder {

    public function newEloquentBuilder($query) 
    {
        
        $class = "\\App\\Builders\\".class_basename($this)."Builder";

        if (!class_exists($class)) {
            throw new Exception("Builder [$class] does not exist.");
        }
        return new $class($query);

    }

}