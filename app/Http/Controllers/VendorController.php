<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index(){
        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = Vendor::where(function ($query) use ($str){
                                $query->where('name', 'like', '%'.$str.'%')
                                ->orWhere('mobile', 'like', '%'.$str.'%')
                                ->orWhere('email', 'like', '%'.$str.'%')
                                ->orWhere('address', 'like', '%'.$str.'%');
                            })
                            ->where('is_delete', 0)
                            ->latest()->paginate(10);
        }else{
            $datas = Vendor::latest()->where('is_delete', 0)->paginate(10);
        }
        return view('admin.vendor.manage', compact('datas'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function open_vendor_form(){
        return view('admin.vendor.addnew');
    }

    public function set_vendor(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_vendor');
        }
        
        DB::beginTransaction();
        try{
            $data = new Vendor();
            
            $input = $request->all();
            $data->fill($input)->save();
    
            if(!empty($request->input('balance')) && $request->input('balance')>0){
                $vendor_id = $data->id;
                $due_acc_id = Bankacc::where('type', 'Cash')->pluck('id');
                $trnxdata = [
                    'account_id' => $due_acc_id[0],
                    'user_id' => Auth::id(),
                    'tranx_date' => date("Y-m-d"),
                    'ref_id' => $vendor_id,
                    'ref_type' => 'vendor',
                    'note' => 'Vendor Opening Due Balance',
                    'amount' => ($request->input('balance') * -1)
                ];
                $tdata = new AccountTranx();
                $tdata->fill($trnxdata)->save();
            }
            flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Added Successfully.');
            DB::rollback();
        }
        return redirect('vendor');
    }

    public function edit_vendor($id){
        $vendor = Vendor::findOrFail($id);
        $vTrnx = AccountTranx::where('ref_id', $id)
                                ->where('ref_type', 'vendor')
                                ->where('note', 'Vendor Opening Due Balance')
                                ->get();
        return view('admin.vendor.edit', compact('vendor', 'vTrnx'));
    }
    
    public function update_vendor(Request $request, $id){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_new_vendor');
        }
        
        DB::beginTransaction();
        try{
            $old_trnx = $request->input('old_opening_balance');
            
            $trnx_need_update = 0;
            if($old_trnx && $old_trnx != abs($request->input('opening_balance')) ){
                $vTrnx = AccountTranx::findOrFail($request->input('old_opening_balance_id'));
                $vTrnx->amount = $request->input('opening_balance')*1;
                $vTrnx->save();

                if($old_trnx > $request->input('opening_balance') ){
                    $trnx_need_update = $old_trnx - $request->input('opening_balance');
                }
                elseif($old_trnx < $request->input('opening_balance') ){
                    $trnx_need_update = $old_trnx - $request->input('opening_balance');
                }
            }

            $data = Vendor::findOrFail($id);
            
            $input = $request->all();
            if($trnx_need_update != 0){
                $input['balance'] = $data->balance - $trnx_need_update;
            }
            $data->update($input);

            DB::commit();
            // If all queries succeed, commit the transaction
            flash()->addSuccess('Data Update Successfully.');
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Updated Successfully.');
            DB::rollback();
        }
        return redirect('vendor');
    }

    public function delete_vendor($id){
        $data = Vendor::findOrFail($id);
        $data->is_delete = 1;
        $data->save();
        flash()->addSuccess('Data Delete Successfully.');
        return redirect('vendor');
    }

    public function see_vendor($id){
        $vendor = Vendor::findOrFail($id);
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
                            ->where('ref_type', 'vendor')
                            ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                            ->latest()->paginate(10);
        }else{
            $datas = AccountTranx::join('bankaccs', 'account_tranxes.account_id', '=', 'bankaccs.id')
                    ->where('ref_id', $id)
                    ->where('ref_type', 'vendor')
                    ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                    ->latest()->paginate(10);
        }
        return view('admin.vendor.details', compact('vendor', 'banks', 'datas'))->with('i', (request()->input('page', 1) - 1) * 10);
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
            $vendor = Vendor::findOrFail($request->input('ref_id'));
            if($vendor){
                $vendor->balance = $vendor->balance - $request->input('amount');
                $vendor->save();
            }
    
            $data = new AccountTranx();
            
            $input = $request->all();
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
