<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use App\Models\Attendance;
use App\Models\Device_attendance;

class ApiController extends Controller
{
    public function receiveData(Request $request)
    {
        // $device_attendance = json_decode($request->all());
        $device_attendance = json_decode($request->getContent(), true);

        // try{
        //     DB::beginTransaction();
        //     if(count($device_attendance)>0){
        //         $ddata = array();
        //         $flag = array();
        //         $eattdata = array();
        //         foreach($device_attendance as $row){
        //             $ddata[] = array(
        //                 'uid'=>$row['uid'],
        //                 'emp_id'=>$row['user_id'],
        //                 'state'=>$row['status'],
        //                 'timestamp'=>$row['timestamp'],
        //                 'type'=>$row['type']
        //             );
        //             // if($row['user_id'] != '902770' && array_search($row['user_id'], $flag, true) === false){
        //             //     $empatt = Attendance::where('emp_id', $row['user_id'])->where('date', date('Y-m-d', strtotime($row['timestamp'])))->pluck('id');
        //             //     if(count($empatt) == 0){
        //             //         $flag[] = $row["user_id"];
        //             //         $eattdata[] = array(
        //             //             'date'=>date('Y-m-d', strtotime($row['timestamp'])),
        //             //             'emp_id'=>$row['user_id'],
        //             //             'hours'=>8,
        //             //             'user_id'=>1,
        //             //             'created_at'=>date('Y-m-d H:i:s', time()),
        //             //             'updated_at'=>date('Y-m-d H:i:s', time()),
        //             //         );
        //             //     }
        //             // }
        //         }
        //         if(count($ddata)>0)
        //             Device_attendance::insert($ddata);
        //         // if(count($eattdata)>0)
        //         //     Attendance::insert($eattdata);
                
        //         DB::commit();
        //     }
        // }catch(\Exception $e) {
        //     DB::rollback();
        //     // activity()->log('Failed to save device data. Bcoz' . $e->getMessage());
        //     return response()->json(array("status"=> false, "error1"=>$e->getMessage()));
        // }
        // activity()->log('Device data save successfully at ' . date('Y-m-d h:i:s a', time()));
        return response()->json(["status"=> true, "message"=> "Device data save successfully", "device_attendance"=>$device_attendance ]);
    }
}
