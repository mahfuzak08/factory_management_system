<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Bankacc;


class InventoryController extends Controller
{
    public function category(){
        $banks = Bankacc::all();
        return view('admin.inventory.category.manage', compact('banks'));
    }
}
