<?php

namespace App\Http\Controllers;

use App\Traits\TodoTrait;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use TodoTrait;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        $val = $this->RandomString(); 
        dd($val);

    }
}
