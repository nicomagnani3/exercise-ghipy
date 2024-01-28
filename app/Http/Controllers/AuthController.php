<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use app\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

	    $credentials = $request->only('email', 'password');
	    if (Auth::attempt($credentials)) {
                $user = User::find(Auth::user()->id);
                $token = $user->createToken(Auth::user()->email)->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
        }
        $response = ["message" =>'User or password incorrect'];
        return response($response, 422);    
    }
}
