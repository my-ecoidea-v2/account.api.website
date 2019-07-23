<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request) 
    {
        
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:75',
                'firstname' => 'required|string|max:40',
                'email' => 'required|string|email|max:191|unique:users',
                'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $confirmation_token = str_random(30);

        $user = User::create([
            'name' => $request->get('name'),
            'firstname' => $request->get('firstname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'confirmation_token' => $confirmation_token
        ]);

        // Mail::send('email.verify', $confirmation_token, function($message) {
        //     $message
        //         ->to(Input::get('email'), Input::get('firstname'))
        //         ->subject('Verify your email address');
        // });

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function confirm(Request $request)
    {
        if( ! $request)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($request)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->request = null;
        $user->save();

        Flash::message('You have successfully verified your account.');

        return Redirect::route('login_path');
    }

    public function logout() {
        JWTAuth::invalidate();
    
        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }

    public function getAuthenticatedUser()
        {
                try {

                        if (! $user = JWTAuth::parseToken()->authenticate()) {
                                return response()->json(['user_not_found'], 404);
                        }

                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                        return response()->json(['token_expired'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                        return response()->json(['token_invalid'], $e->getStatusCode());

                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                        return response()->json(['token_absent'], $e->getStatusCode());

                }

                return response()->json(compact('user'));
        }
}