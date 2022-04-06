<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\UserRegisterRequest;
use App\Notifications\PasswordResetNotification;
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

    public function recover(Request $request) 
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        Password::sendResetLink(
            $request->only('email')
        );

        return response()->noContent(200);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));
     
                $user->save();
                $user->notify(new PasswordResetNotification());
                $user->tokens()->delete();
     
                event(new PasswordReset($user));
            }
        );
        if (!$status == Password::PASSWORD_RESET){
            return response()->noContent(500);
        }
        return response()->noContent(200);
        
    }
}


// A lot of lessons learned / and Not learned