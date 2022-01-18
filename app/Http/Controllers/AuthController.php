<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){

        $auth = [
            'username' => $request->get('username'),
            'password' => $password = $request->get('password'),
        ];

        if (Auth::attempt($auth, false)){
            return response()->json([
                'user' => Auth::user()
            ], 200); 
        }else{
            return response()->json([
                'error' => 'Invalid authentication'
            ], 401); //401 unauthenticated
        }
    }

    public function logout(){
        Auth::logout();
        return response()->json([
            'user' => Auth::user()
        ], 202); 
    }
}
