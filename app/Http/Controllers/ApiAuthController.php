<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTExceptions;
class ApiAuthController extends Controller
{
    public function authenticate()
    {
        $credentials = request()->only('email','password');
        try{
            $token = JWTAuth::attempt($credentials);
            if(!$token){
                return response()->json(['error'=>'invalid_credentials'],401);
            }
        }
        catch(JWTExceptions $e){
            return response()->json(['error'=> 'somthing_went_wong']);
        }
        return response()->json(['token' => $token],200);
    }
    public  function register(Request $request)
    {
        $user = User::create([
            'name'=> $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')) 
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(['token' => $token],200);
    }
}
