<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class SettingsController extends Controller
{
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
    
    public function user_manage(){
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = User::where(function ($query) use ($str){
                                $query->where('name', 'like', '%'.$str.'%')
                                ->orWhere('mobile', 'like', '%'.$str.'%')
                                ->orWhere('email', 'like', '%'.$str.'%')
                                ->orWhere('role', 'like', '%'.$str.'%');
                            })
                            ->latest()->paginate(10);
        }else{
            $datas = User::latest()->paginate(10);
        }
        return view('admin.settings.users', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function see_user($id){
        $user = User::findOrFail($id);
        return view('admin.settings.user-details', compact('user'));
    }
    
    public function edit_user($id){
        $user = User::findOrFail($id);
        return view('admin.settings.user-edit', compact('user'));
    }
    
    public function update_customer(Request $request, $id){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_customer');
        }
        
        DB::beginTransaction();
        try{
            $data = Customer::findOrFail($id);
            
            $input = $request->all();
            if($data->opening_balance != $input['opening_balance'])
                $input['balance'] = $data->balance - ($data->opening_balance - $input['opening_balance']);
            else
                $input['balance'] = $data->balance;
            
            $data->update($input);

            DB::commit();
            // If all queries succeed, commit the transaction
            flash()->addSuccess('Data Update Successfully.');
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Updated Successfully.');
            DB::rollback();
        }
        return redirect('customer');
    }

}
