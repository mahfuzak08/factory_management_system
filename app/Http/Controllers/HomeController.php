<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Expense_detail;
use App\Models\Attendance;
use App\Models\Device;

class HomeController extends Controller
{
    public function dashboard(){
        activity()->log('Logged in');
        $device = Device::all();
        $ip = getHostByName(getHostName());
        $run_script = $this->isSameSubnet($device[0]->ip, $ip);
        
        $data['today_total_purchase'] = Purchase::where('status', 1)
                                                ->where('date', '=', date('Y-m-d'))
                                                ->sum('total');
        $data['today_total_sale'] = Sales::where('status', 1)
                                                ->where('date', '=', date('Y-m-d'))
                                                ->sum('total');
        $data['today_total_expense'] = Expense_detail::where('trnx_date', '=', date('Y-m-d'))
                                                ->sum('amount');
        $data['today_total_attendance'] = Attendance::where('date', '=', date('Y-m-d'))
                                                ->where('hours', '=', 8)
                                                ->count();
        return view('admin.home', compact('data', 'run_script'));
    }
}
