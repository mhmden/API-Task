<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use NumberFormatter;
use Symfony\Component\Console\Output\ConsoleOutput;



class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->successWithToken($token);
        // (new ConsoleOutput())->writeln("");
    }

    public function login(UserLoginRequest $request) // Validation Rule are in fact bette
    {
        $user = User::firstWhere('email', $request->validated('email'));
        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            $response = response()->unauthenticated();
        } else {
            $token = $user->createToken('auth_token')->plainTextToken;
            $response = response()->successWithToken($token);
        }
        return $response;
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('You have been logged out!');
    }
}


// A lot of lessons learned / and Not learned