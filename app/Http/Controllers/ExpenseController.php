<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Expense;
use App\Models\Expense_detail;

class ExpenseController extends Controller
{
    public function index(){
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = Expense::where('name', 'like', '%'.$str.'%')
                            ->where('status', 1)
                            ->latest()->paginate(10);
        }else{
            $datas = Expense::latest()->where('status', 1)->paginate(10);
        }
        return view('admin.expense.manage', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function open_expense_form(){
        return view('admin.expense.addnew');
    }

    public function set_expense(Request $request){
        // print_r($request->all());
        $rules = [
            'name' => ['required', 'string', 'max:255']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_expense');
        }

        $data = new Expense();
        
        $input = $request->all();
        $input["created_by"] = Auth::id();

        $data->fill($input)->save();
        flash()->addSuccess('New Data Added Successfully.');
        return redirect('expense');
    }

    public function edit_expense($id){
        $expense = Expense::findOrFail($id);
        return view('admin.expense.edit', compact('expense'));
    }

    public function update_expense(Request $request, $id){
        $rules = [
            'name' => ['required', 'string', 'max:255']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('edit_expense', $id);
        }

        $data = Expense::findOrFail($id);
        
        $input = $request->all();
        
        $data->update($input);
        flash()->addSuccess('Data Updated Successfully.');
        return redirect('expense');
    }

    public function delete_expense($id){
        $data = Expense::findOrFail($id);
        $data->fill(['status'=>0])->update();
        flash()->addSuccess('Data Delete Successfully.');
        return redirect('expense');
    }

    public function expense_details($id){
        $expense = Expense::findOrFail($id);
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
                            ->where('ref_type', 'expense')
                            ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                            ->latest()->paginate(10);
        }else{
            $datas = AccountTranx::join('bankaccs', 'account_tranxes.account_id', '=', 'bankaccs.id')
                    ->where('ref_id', $id)
                    ->where('ref_type', 'expense')
                    ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                    ->latest()->paginate(10);
        }
        return view('admin.expense.details', compact('expense', 'banks', 'datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function add_expense_amount(Request $request){
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
            $ex_order = new Expense_detail();
            $ex_input = [
                "trnx_date"=> $request->input("tranx_date"),
                "expense_id"=> $request->input("ref_id"),
                "user_id"=> Auth::id(),
                "account_id"=> $request->input("account_id"),
                "amount"=> $request->input("amount"),
                "title"=> $request->input("title"),
                "details"=> $request->input("details")
            ];

            $data = new AccountTranx();
            
            $input = $request->all();
            $input['user_id'] = Auth::id();
            $input['amount'] *= -1;
            
            $data->fill($input)->save();
            
            flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            dd($e);
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Added Successfully.');
            DB::rollback();
        }
        return redirect($request->input('redirect_url'));
    }

}
