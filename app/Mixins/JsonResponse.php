<?php

// A class dedicated to creating macros which is cool

namespace App\Mixins;

class JsonResponse
{
    public function successWithToken()
    {
        return function ($token) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        };
    }

    public function unauthenticated() // change 
    {
        return function () {
            return response()->json([
                'message' => 'invalid credentials',
            ], 401); // 403 is for privileges
        };
    }
}

// Use 403 for actions for users who have been authenticated 
// Use 401 for login / Register  

// authentication is the process of verifying who someone is
// authorization is the process of verifying what specific applications, files, and data a user has access to

/* He suggests doing the opposite ???

In summary, a 401 Unauthorized response should be used for missing or bad authentication, and a 403 Forbidden response should be used afterwards, when the user is authenticated but isn’t authorized to perform the requested operation on the given resource.


*/