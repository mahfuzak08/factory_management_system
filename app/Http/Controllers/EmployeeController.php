<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(){
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = Employee::where(function ($query) use ($str){
                                $query->where('name', 'like', '%'.$str.'%')
                                ->orWhere('mobile', 'like', '%'.$str.'%')
                                ->orWhere('gender', 'like', '%'.$str.'%')
                                ->orWhere('nid', 'like', '%'.$str.'%')
                                ->orWhere('address', 'like', '%'.$str.'%');
                            })
                            ->latest()->paginate(10);
        }else{
            $datas = Employee::latest()->paginate(10);
        }
        return view('admin.employee.manage', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function open_employee_form(){
        return view('admin.employee.addnew');
    }

    public function set_employee(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13', 'unique:employees,mobile']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_employee');
        }
        
        DB::beginTransaction();
        try{
            $data = new Employee();
            
            $input = $request->all();
            $input['salary'] = empty($input['salary']) ? 0 : $input['salary']; 
            $input['bonus'] = empty($input['bonus']) ? 0 : $input['bonus'];
            $data->fill($input)->save();
    
            flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            dd($e);
            exit();
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Added Successfully.');
            DB::rollback();
        }
        return redirect('employee');
    }

    public function edit_employee($id){
        $employee = Employee::findOrFail($id);
        return view('admin.employee.edit', compact('employee'));
    }
    
    public function update_employee(Request $request, $id){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_employee');
        }
        
        DB::beginTransaction();
        try{
            $data = Employee::findOrFail($id);
            $input = $request->all();
            $input['salary'] = empty($input['salary']) ? $data->salary : $input['salary']; 
            $input['bonus'] = empty($input['bonus']) ? $data->bonus : $input['bonus'];
            $data->update($input);

            DB::commit();
            // If all queries succeed, commit the transaction
            flash()->addSuccess('Data Update Successfully.');
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Updated Successfully.');
            DB::rollback();
        }
        return redirect('employee');
    }

    public function delete_employee($id){
        $data = Employee::findOrFail($id);
        $data->closing = date('Y-m-d');
        $data->save();
        flash()->addSuccess('Data Delete Successfully.');
        return redirect('employee');
    }

    public function see_employee($id){
        $employee = Employee::findOrFail($id);
        $banks = Bankacc::where('type', '!=', 'Due')->get();
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = AccountTranx::join('bankaccs', 'account_tranxes.account_id', '=', 'bankaccs.id')
                            ->where(function ($query) use ($str){
                                $query->where('tranx_date', 'like', '%'.$str.'%')
                                ->orWhere('amount', 'like', '%'.$str.'%')
                                ->orWhere('bankaccs.name', 'like', '%'.$str.'%')
                                ->orWhere('note', 'like', '%'.$str.'%');
                            })
                            ->where('ref_id', $id)
                            ->where('ref_type', 'employee')
                            ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                            ->latest()->paginate(10);
        }else{
            $datas = AccountTranx::join('bankaccs', 'account_tranxes.account_id', '=', 'bankaccs.id')
                    ->where('ref_id', $id)
                    ->where('ref_type', 'employee')
                    ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                    ->latest()->paginate(10);
        }
        $total_receive = AccountTranx::where('ref_id', $id)->where('ref_type', 'employee')->sum('amount');
        return view('admin.employee.details', compact('employee', 'banks', 'datas', 'total_receive'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function add_amount(Request $request){
        $rules = [
            'account_id' => ['required'],
            'tranx_date' => ['required', 'date'],
            'amount' => ['required', 'numeric']
        ];
        $id = $request->input('account_id');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect($request->input('redirect_url'));
        }

        DB::beginTransaction();
        try{
            $data = new AccountTranx();
            
            $input = $request->all();
            $input['amount'] *= -1;
            $input['user_id'] = Auth::id();
            
            $data->fill($input)->save();
    
            flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Added Successfully.');
            DB::rollback();
        }
        return redirect($request->input('redirect_url'));
    }

}
