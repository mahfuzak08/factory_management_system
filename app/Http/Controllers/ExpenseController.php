<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;

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
}
