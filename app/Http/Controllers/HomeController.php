<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class HomeController extends Controller
{
    public function dashboard(){

        activity()->log('Logged in');
        return view('admin.home');
    }
}
