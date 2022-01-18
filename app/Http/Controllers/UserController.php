<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsers(){
        try{
            $user = User::all();
        }catch (Exception $e){
            return response()->json([
                'Error' => 'An error has occured'
            ], 500); //500 = server/exception error
        }

            return response()->json([
                'users' => $user
            //     'data' => 'this is sample data',
            //     'anotherData' => 'data again',
            //     'number' => 999,
            //     'array_number' => [0, 2, 3, 6],
            //     'array_string' => ["apple","banana","chico"],
            //     'array_assoc' => [
            //         'brand' => "toyota",
            //         'model' => "supra"
            //     ],
            //     'cars' => [
            //         'name' => "plate",
            //         'price' => 99.99
            //     ],
            //     [
            //         'name' => "bread",
            //         'price => 20.00'
            //     ]
             ], 200); //200 = success query
    }

    public function addUser(Request $request){
        try{
            //1. Check if  email or username exist
            $user = User::where('email', $request->get('email'))
                -> orWhere ('username', $request->get('username'))
                -> first();
            if ($user){
                throw new Exception("Email/Username already exist.");
            }
            
            //2. if no record exist, do insert
            //ADD USER
            $user = new User();
            $user->first_name = $request->get('first_name');
            $user->middle_name = $request->get('middle_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->username = $request->get('username');
            $user->password = Hash::make($request->get('password'));
            $user->save();
        }catch (Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 500); 
        }
            return response()->json([
                'user' => [
                    'name' => $user
                ]
            ], 201); //200 = success add
    }

    public function editUser(String $id, Request $request){
            try {
                //1. Query if email/username is in use
                $user = User::where('email', $request->get('email'))
                    ->orWhere('username', $request->get('username'))
                    ->first();
                if ($user) {
                    throw new Exception("Email/username already in use.");
                }
                //2. Query specifc user
                $user = User::where('id', $id)
                    ->first();
                if (!$user) {
                    throw new Exception("User ID does not exist.");
                }
                //3. If record exist do update
                if ($request->has('first_name')) {
                    $user->first_name = $request->get('first_name');
                }
                if ($request->has('middle_name')) {
                    $user->middle_name = $request->get('middle_name');
                }
                if ($request->has('last_name')) {
                    $user->last_name = $request->get('last_name');
                }
                if ($request->has('email')) {
                    $user->email = $request->get('email');
                }
                if ($request->has('username')) {
                    $user->username = $request->get('username');
                }
                if ($request->has('password')) {
                    $user->password = Hash::make($request->get('password'));
                }
                $user->save();
            } catch (Exception $e) {
                return response()->json([
                    'Error' => $e->getMessage()
                ], 500);
            }
    
            return response()->json([
                'user' => $user
            ], 202);
        }

    public function deleteUser(String $id, Request $request){
        try{
            $user = User::where('id', $id)
            -> first();
            if (!$user){
                throw new Exception("User ID does not exist");
            }
            $user -> delete();
        }catch (Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 500); 
        }
            return response()->json([
                'message' => 'User succesfully deleted'
            ], 202); 
    }
}
