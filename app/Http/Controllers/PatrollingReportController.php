<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatrollingReport;
use Hash;
use Exception;

class PatrollingReportController extends Controller
{
    public function getPatrollingReport(){
        try{
            $patrollingreport = PatrollingReport::all();
        }catch (Exception $e){
            return response()->json([
                'Error' => 'An error has occured'
            ], 500); //500 = server/exception error
        }
            return response()->json([
                'patrollingreport' => $patrollingreport
             ], 200); //200 = success query
    }

    public function addPatrollingReport(Request $request){
        try{
            //1. Check if  date and time exist
            $patrollingreport = PatrollingReport::where('date', $request->get('date'))
            -> Where ('time', $request->get('time'))
                -> first();
            if ($patrollingreport){
                throw new Exception("Date and Time already exist.");
            }
            
     //2. if no record exist, do insert
        $patrollingreport = new PatrollingReport();
        $patrollingreport->longitude = $request->get('longitude');
        $patrollingreport->latitude = $request->get('latitude');
        $patrollingreport->name = $request->get('name');
        $patrollingreport->date = $request->get('date');
        $patrollingreport->time = $request->get('time');
        $patrollingreport->image = $request->get('image');
        $patrollingreport->remarks = $request->get('remarks');
        $patrollingreport->save();
    }catch (Exception $e){
        return response()->json([
            'Error' => $e->getMessage()
        ], 500); 
    }
        return response()->json([
            'patrollingreport' => [
                'patrollingreport' => $patrollingreport
            ]
        ], 201); //200 = success add
    }

    public function deletePatrollingReport(String $id, Request $request){
    try{
        $patrollingreport = PatrollingReport::where('id', $id)
        -> first();
        if (!$patrollingreport){
            throw new Exception("Patrolling Report ID does not exist");
        }
        $patrollingreport -> delete();
    }catch (Exception $e){
        return response()->json([
            'Error' => $e->getMessage()
        ], 500); 
    }
        return response()->json([
            'message' => 'Patrolling Report succesfully deleted'
        ], 202); 
    }

    public function editPatrollingReport(String $id, Request $request){
    try {
        //1. Query
        $patrollingreport = PatrollingReport::where('date', $request->get('date'))
        -> Where ('time', $request->get('time'))
            ->first();
        if ($patrollingreport) {
            throw new Exception("Date and Time already in use.");
        }
        //2. Query specifc 
        $patrollingreport = PatrollingReport::where('id', $id)
            ->first();
        if (!$patrollingreport) {
            throw new Exception("Schedule ID does not exist.");
        }
        //3. If record exist do update
        if ($request->has('longitude')) {
            $patrollingreport->longitude = $request->get('longitude');
        }
        if ($request->has('latitude')) {
            $patrollingreport->latitude = $request->get('latitude');
        }
        if ($request->has('name')) {
            $patrollingreport->name = $request->get('name');
        }
        if ($request->has('date')) {
            $patrollingreport->date = $request->get('date');
        }
        if ($request->has('time')) {
            $patrollingreport->time = $request->get('time');
        }
        if ($request->has('image')) {
            $patrollingreport->image = $request->get('image');
        }
        if ($request->has('remarks')) {
            $patrollingreport->remarks = $request->get('remarks');
        }
        $patrollingreport->save();
    } catch (Exception $e) {
        return response()->json([
            'Error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'patrollingreport' => $patrollingreport
    ], 202);
    }
}
