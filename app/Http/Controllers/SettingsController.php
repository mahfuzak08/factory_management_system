<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Sms_log;
use App\Notifications\SendSms;

class SettingsController extends Controller
{
    /**
     * Language Setup
     */
    public function language(){
        return view('admin.settings.language');
    }
    
    public function language_change(Request $request){
        $user = User::find(Auth::id());
        if ($user) {
            $user->update(["lang"=>$request->input("lang")]);
            if ($user->wasChanged('lang')) {
                flash()->addSuccess('Language Update Successfully.');
            } else {
                dd($user);
            }
        }
        return redirect('language');
    }
    // End Language Setup

    /**
     * User Management
     */
    public function user_manage(){
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = User::where(function ($query) use ($str){
                                $query->where('name', 'like', '%'.$str.'%')
                                ->orWhere('mobile', 'like', '%'.$str.'%')
                                ->orWhere('email', 'like', '%'.$str.'%')
                                ->orWhere('role', 'like', '%'.$str.'%');
                            })
                            ->latest()->paginate(10)->withQueryString();
        }else{
            $datas = User::latest()->paginate(10)->withQueryString();
        }
        return view('admin.settings.users', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function see_user($id){
        $user = User::findOrFail($id);
        return view('admin.settings.user-details', compact('user'));
    }
    
    public function edit_user($id){
        $user = User::findOrFail($id);
        $role = Role::get(['id', 'name']);
        return view('admin.settings.user-edit', compact('user', 'role'));
    }
    
    public function open_user_form(){
        $role = Role::get(['id', 'name']);
        return view('admin.settings.user-addnew', compact('role'));
    }
    
    public function update_user(Request $request, $id){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13'],
            'email' => ['email', 'nullable'],
            'role_id' => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect($request->input('redirect_url'));
        }
        
        DB::beginTransaction();
        try{
            $data = User::findOrFail($id);
            
            $input = $request->all();
            $data->update($input);

            DB::commit();
            // If all queries succeed, commit the transaction
            flash()->addSuccess('Data Update Successfully.');
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Updated Successfully.');
            DB::rollback();
        }
        return redirect('user_manage');
    }
    // End User Management

    /**
     * Role Management
     */
    public function role_manage(){
        $role = Role::all();
        return view('admin.settings.role', compact('role'));
    }

    public function open_role_form(){
        return view('admin.settings.role-addnew');
    }

    public function set_role(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('role_manage');
        }
        if(! empty($request->input('id'))){
            $db = Role::findOrFail($request->input('id'));
        }else{
            $db = new Role();
        }
        $module = implode(',', $request->input('module'));
        $db->fill(["name"=>$request->input("name"), "module"=>json_encode($module)])->save();
        flash()->addSuccess('Role Added/ Update Successfully.');
        return redirect('role_manage');
    }

    public function edit_role($id){
        $role = Role::findOrFail($id);
        return view('admin.settings.role-edit', compact('role'));
    }
    // End Role Management

    /**
     * SMS Management
     */
    public function sms(){
        if(empty(request()->input('search')) && empty($_GET['page'])){
            $smsClass = new SendSms();
            $bal = $smsClass->getBalance();
            session(['SMSbal'=> $bal]);
        }
        else{
            $bal = session('SMSbal');
        }
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $sms = Sms_log::Where('contacts', 'like', '%'.$str.'%')
                            ->orWhere('msg', 'like', '%'.$str.'%')
                            ->select('id', 'msg', 'contacts', 'response')
                            ->latest()->paginate(10)->withQueryString();
        }
        else{
            $sms = Sms_log::select('id', 'created_at', 'msg', 'contacts', 'response')->latest()->paginate(10)->withQueryString();
        }
        return view('admin.settings.sms', compact('sms', 'bal'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
