<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Route;
use Hash;
use Exception;

class RouteController extends Controller
{
    public function getRoute(){
        try{
            $route = Route::all();
        }catch (Exception $e){
            return response()->json([
                'Error' => 'An error has occured'
            ], 500); //500 = server/exception error
        }
            return response()->json([
                'route' => $route
             ], 200); //200 = success query
    }

    public function addRoute(Request $request){
        try{
            //1. Check if  email or username exist
            $route = Route::where('schedule', $request->get('schedule'))
                -> first();
            if ($route){
                throw new Exception("Schedule already exist.");
            }
            
            //2. if no record exist, do insert
            $route = new Route();
            $route->schedule = $request->get('schedule');
            $route->security_personnel = $request->get('security_personnel');
            $route->post = $request->get('post');
            $route->save();
        }catch (Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 500); 
        }
            return response()->json([
                'route' => [
                    'route' => $route
                ]
            ], 201); //200 = success add
    }

    public function deleteRoute(String $id, Request $request){
        try{
            $route = Route::where('id', $id)
            -> first();
            if (!$route){
                throw new Exception("Schedule ID does not exist");
            }
            $route -> delete();
        }catch (Exception $e){
            return response()->json([
                'Error' => $e->getMessage()
            ], 500); 
        }
            return response()->json([
                'message' => 'Schedule succesfully deleted'
            ], 202); 
    }

    public function editRoute(String $id, Request $request){
        try {
            //1. Query
            $route = Route::where('schedule', $request->get('schedule'))
                ->first();
            if ($route) {
                throw new Exception("Schedule already in use.");
            }
            //2. Query specifc 
            $route = Route::where('id', $id)
                ->first();
            if (!$route) {
                throw new Exception("Schedule ID does not exist.");
            }
            //3. If record exist do update
            if ($request->has('schedule')) {
                $route->schedule = $request->get('schedule');
            }
            if ($request->has('security_personnel')) {
                $route->security_personnel = $request->get('security_personnel');
            }
            if ($request->has('post')) {
                $route->post = $request->get('post');
            }
            $route->save();
        } catch (Exception $e) {
            return response()->json([
                'Error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'route' => $route
        ], 202);
    }
}