<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Events\AttemptingLogin;
use App\Events\Failed;
use App\Events\LoginSuccess;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller 
{

    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(Request $request) {

        event(new AttemptingLogin($request));
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            event(new Failed($request));
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($request->input('password'), $user->password)) {
            event(new LoginSuccess($user));
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }

        // Bad Request response
        event(new Failed($request));
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }
}