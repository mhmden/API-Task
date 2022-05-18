<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Banned
            // $BannedUserList = User::banned()->get(['id', 'email']);
        
        // Active
        $activeUsers = User::active()->get(['id', 'email']);

        return response()->json($activeUsers);
    }
}
