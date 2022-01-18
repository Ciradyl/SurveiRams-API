<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    AuthController,
    RouteController,
    PatrollingReportController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([]) -> group(function(){

    Route::post(
        '/login',
        [AuthController::class,'login'] 
     ) -> name('auth.login'); 
     Route::get(
        '/logout',
        [AuthController::class,'logout'] 
     ) -> name('auth.logout'); 

    ///////////////////////////////////////////////////// USER
    Route::get(
       '/users', //controller name
       [UserController::class,'getUsers'] //method name
    ) -> name('user.getusers'); //view

    Route::post(
        '/user',
        [UserController::class,'addUser']
    ) -> name('user.adduser'); //add

    Route::patch(
        '/user/{id}', //parse id
        [UserController::class,'editUser']
    ) -> name('user.edituser'); //update (put=override update | Patch=update the only needed updates)

    Route::delete(
        '/user/{id}',
        [UserController::class,'deleteUser']
    ) -> name('user.deleteuser'); //delete

     ///////////////////////////////////////////////////// MAKE
    Route::get(
        '/route', //controller name
        [RouteController::class,'getRoute'] //method name
     ) -> name('route.getroute'); //view
 
     Route::post(
         '/route',
         [RouteController::class,'addRoute']
     ) -> name('route.addroute'); //add
 
     Route::patch(
         '/route/{id}', //parse id
         [RouteController::class,'editRoute']
     ) -> name('route.editroute'); //update (put=override update | Patch=update the only needed updates)
 
     Route::delete(
         '/route/{id}',
         [RouteController::class,'deleteRoute']
     ) -> name('route.deleteroute'); //delete

     ///////////////////////////////////////////////////// PATROLLING REPORT
    Route::get(
        '/patrollingreport', //controller name
        [PatrollingReportController::class,'getPatrollingReport'] //method name
     ) -> name('patrollingreport.getpatrollingreport'); //view
 
     Route::post(
         '/patrollingreport',
         [PatrollingReportController::class,'addPatrollingReport']
     ) -> name('patrollingreport.addpatrollingreport'); //add
 
     Route::patch(
         '/patrollingreport/{id}', //parse id
         [PatrollingReportController::class,'editPatrollingReport']
     ) -> name('patrollingreport.editpatrollingreport'); //update (put=override update | Patch=update the only needed updates)
 
     Route::delete(
         '/patrollingreport/{id}',
         [PatrollingReportController::class,'deletePatrollingReport']
     ) -> name('patrollingreport.deletepatrollingreport'); //delete
});
