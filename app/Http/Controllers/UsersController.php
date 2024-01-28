<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;


class UsersController extends Controller
{

    public function store()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            // successfull authentication
            $user = User::find(Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->accessToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
    
    public function login(){

    if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

      $user = Auth::user();

      $success['token'] = $user->createToken('appToken')->accessToken;

      //After successfull authentication, notice how I return json parameters

      return response()->json([

       'success' => true,

       'token' => $success,

       'user' => $user

     ]);

    } else {

    //if authentication is unsuccessfull, notice how I return json parameters

     return response()->json([

      'success' => false,

      'message' => 'Invalid Email or Password',

    ], 401);

    }

  }

  /**

   * Register api.

   *

   * @return \Illuminate\Http\Response

   */

   public function register(Request $request)

   {
 
     $validator = Validator::make($request->all(), [
 
       'firstname' => 'required',
 
       'larstname' => 'required',
 
       'phone' => 'required|unique:users|regex:/(0)[0-9]{10}/',
 
       'email' => 'required|email|unique:users',
 
       'password' => 'required',
 
     ]);
 
     if ($validator->fails()) {
 
      return response()->json([
 
       'success' => false,
 
       'message' => $validator->errors(),
 
      ], 401);
 
     }
 
     $input = $request->all();
 
     $input['password'] = bcrypt($input['password']);
 
     $user = User::create($input);
 
     $success['token'] = $user->createToken('appToken')->accessToken;
 
     return response()->json([
 
      'success' => true,
 
      'token' => $success,
 
      'user' => $user
 
    ]);
 
   }
 
 
 
   public function users()
 
   {
 
     if (Auth::user()) {
 
       $users = User::all();
 
 
 
       return response()->json([
 
         'success' => true,
 
         'data' => $users
 
       ]);
 
     }else {
 
       return response()->json([
 
         'success' => false,
 
         'message' => 'Unable to Logout'
 
       ]);
 
     }
 
   }
 
 
 
   public function logout(Request $res)
 
   {
 
    if (Auth::user()) {
 
     $user = Auth::user()->token();
 
     $user->revoke();
 
 
 
     return response()->json([
 
      'success' => true,
 
      'message' => 'Logout successfully'
 
    ]);
 
    }else {
 
     return response()->json([
 
      'success' => false,
 
      'message' => 'Unable to Logout'
 
     ]);
 
    }
 
    }
 
 
}
