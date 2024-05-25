<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use App\Models\Attendance;
use App\Models\Device_attendance;

class ApiController extends Controller
{
    public function diffInHours($newtime, $oldtime) {
        try {
            $date1=date_create($oldtime);
            $date2=date_create($newtime);
            $diff=date_diff($date1,$date2);
            return $diff->h + ($diff->d * 24);
        } catch (Exception $e) {
            file_put_contents(storage_path('app/error_log.txt'), $e->getMessage());
            return false;
        }
    }
    
    public function receiveData(Request $request)
    {
        // $device_attendance = json_decode($request->all());
        $device_attendance = json_decode(json_decode($request->getContent(), true));
        try{
            DB::beginTransaction();
            if(count($device_attendance)>0){
                $ddata = array();
                foreach($device_attendance as $row){
                    $ddata[] = array(
                        'uid'=>$row->uid,
                        'emp_id'=>$row->user_id,
                        'state'=>$row->status,
                        'timestamp'=>$row->timestamp,
                        'type'=>$row->type
                    );
                    if($row->user_id != '902770'){
                        // new attendance for today 
                        $latest_attendance = Attendance::where('emp_id', $row->user_id)->latest('id')->first();
                        if($latest_attendance){
                            $hours_difference = $this->diffInHours($row->timestamp, $latest_attendance->intime);
                        }
                        else{
                            $hours_difference = null;
                        }
                            
                        if(!$latest_attendance || $hours_difference>=16){
                            if($latest_attendance && $latest_attendance->outtime == null){
                                // forgot to punch
                                Attendance::where('id', $latest_attendance->id)->update(['outtime'=> $row->timestamp]);
                            }

                            // Add a new entry with intime set to the current timestamp
                            Attendance::create([
                                'date' => date('Y-m-d', strtotime($row->timestamp)),
                                'emp_id' => $row->user_id,
                                'intime' => $row->timestamp,
                                'user_id' => 1,
                            ]);
                        }
                        elseif($hours_difference>=1){
                            Attendance::where('id', $latest_attendance->id)->update(['outtime'=> $row->timestamp]);
                        }
                    
                    }
                }

                if(count($ddata)>0)
                    Device_attendance::insert($ddata);

                DB::commit();
            }
        }catch(\Exception $e) {
            DB::rollback();
            file_put_contents(storage_path('app/Line96.txt'), $e->getMessage());
            return response()->json(array("status"=> false, "error1"=>$e->getMessage()));
        }
        activity()->log('Device data save successfully at ' . date('Y-m-d h:i:s a', time()));
        return response()->json(["status"=> true, "message"=> "Device data save successfully", "device_attendance"=>$device_attendance ]);
    }
}
