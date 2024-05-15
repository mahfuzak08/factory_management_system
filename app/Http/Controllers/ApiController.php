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
        $device_attendance = $request->all();
        // try{
        //     DB::beginTransaction();
        //     if(count($device_attendance)>0){
        //         $ddata = array();
        //         $flag = array();
        //         foreach($device_attendance as $row){
        //             $eattdata = array();
        //             $ddata[] = array(
        //                 'uid'=>$row['uid'],
        //                 'emp_id'=>$row['id'],
        //                 'state'=>$row['state'],
        //                 'timestamp'=>$row['timestamp'],
        //                 'type'=>$row['type']
        //             );
        //             if($row['id'] != '902770'){
        //                 $empatt = Attendance::where('emp_id', $row['id'])->where('date', date('Y-m-d', strtotime($row['timestamp'])))->pluck('id');
        //                 if(count($empatt) == 0){
        //                     $eattdata[] = array(
        //                         'date'=>date('Y-m-d', strtotime($row['timestamp'])),
        //                         'emp_id'=>$row['id'],
        //                         'hours'=>8,
        //                         'user_id'=>1,
        //                         'created_at'=>date('Y-m-d H:i:s', time()),
        //                         'updated_at'=>date('Y-m-d H:i:s', time()),
        //                     );
        //                     Attendance::insert($eattdata);
        //                 }
        //             }
        //         }
        //         if(count($ddata)>0)
        //             Device_attendance::insert($ddata);
                
        //         DB::commit();
        //     }
        // }catch(\Exception $e) {
        //     DB::rollback();
        //     activity()->log('Failed to save device data. Bcoz' . $e->getMessage());
        //     return response()->json(array("status"=> false, "error1"=>$e->getMessage()));
        // }
        // activity()->log('Device data save successfully at ' . date('Y-m-d h:i:s a', time()));
        return response()->json(["status"=> true, "message"=> "Device data save successfully", "device_attendance"=>$device_attendance ]);
    }
}
