<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SendSms;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Customer;
use App\Models\Sales;

class CustomerController extends Controller
{
    public function index(){
        $ctotal = [];
        $discount_acc_id = Bankacc::where('type', 'Discount')->pluck('id');
        $discountids = "(";
        foreach($discount_acc_id as $r){
            $discountids .= $r.",";
        }
        $discountids = substr($discountids, 0, -1);
        $discountids .= ")";

        if(! empty(request()->input('search'))){
            $str = request()->input('search');
            $datas = Customer::select('customers.*')
                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(total) FROM sales WHERE customer_id = customers.id AND status = 1), 0) - COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer"), 0)) as due'))
                            ->addSelect(DB::raw('COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND account_id NOT IN '.$discountids.'), 0) as receive'))
                            ->where(function ($query) use ($str){
                                $query->where('name', 'like', '%'.$str.'%')
                                ->orWhere('mobile', 'like', '%'.$str.'%')
                                ->orWhere('email', 'like', '%'.$str.'%')
                                ->orWhere('address', 'like', '%'.$str.'%');
                            })
                            ->where('is_delete', 0)
                            ->latest()->paginate(50)->withQueryString();

            
        }else{
            $datas = Customer::select('customers.*')
                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(total) FROM sales WHERE customer_id = customers.id AND status = 1), 0) - COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer"), 0)) as due'))
                            ->addSelect(DB::raw('COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND account_id NOT IN '.$discountids.'), 0) as receive'))
                            ->latest()
                            ->where('is_delete', 0)
                            ->paginate(50)
                            ->withQueryString();

            if(! $datas->hasMorePages()){
                $ts = Sales::where('status', 1)->sum('total');
                $tr = AccountTranx::where('ref_type', 'customer')->sum('amount');
                $td = AccountTranx::where('ref_type', 'customer')->whereIn('account_id', (array) $discount_acc_id)->sum('amount');
                // dd($ts, $tr, $td);
                $ctotal=array("total_sales" => $ts - $td, "total_receive" => $tr);
            }
        }
        
        return view('admin.customer.manage', compact('datas', 'ctotal'))->with('i', (request()->input('page', 1) - 1) * 50);
    }

    public function open_customer_form(){
        return view('admin.customer.addnew');
    }

    public function set_customer(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'digits:13', 'unique:customers,mobile']
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
            $data = new Customer();
            
            $input = $request->all();
            $input['balance'] = empty($input['balance']) || $input['balance'] == null ? 0 : $input['balance'];
            $input['opening_balance'] = $input['balance'];
            $data->fill($input)->save();
    
            // $customer_id = $data->id;
            
            // $due_acc_id = Bankacc::where('type', 'Cash')->pluck('id');
            // $trnxdata = [
            //     'account_id' => $due_acc_id[0],
            //     'user_id' => Auth::id(),
            //     'tranx_date' => date("Y-m-d"),
            //     'ref_id' => $customer_id,
            //     'ref_type' => 'customer',
            //     'note' => 'Customer Opening Due Balance',
            //     'amount' => !empty($request->input('balance')) && $request->input('balance')>0 ? ($request->input('balance') * -1) : 0
            // ];
            // $tdata = new AccountTranx();
            // $tdata->fill($trnxdata)->save();
            
            flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            dd($e);
            exit();
            flash()->addError('Data Not Added Successfully.');
            DB::rollback();
        }
        return redirect('customer');
    }

    public function edit_customer($id){
        $customer = Customer::findOrFail($id);
        // $vTrnx = AccountTranx::where('ref_id', $id)
        //                         ->where('ref_type', 'customer')
        //                         ->where('note', 'Customer Opening Due Balance')
        //                         ->get();
        
        return view('admin.customer.edit', compact('customer'));
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
            return redirect('customer');
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

    public function delete_customer($id){
        $data = Customer::findOrFail($id);
        $data->is_delete = 1;
        $data->save();
        flash()->addSuccess('Data Delete Successfully.');
        return redirect('customer');
    }

    public function isDateBetween($date, $startDate, $endDate) {
        $date = date("Y-m-d", strtotime($date));
        $startDate = date("Y-m-d", strtotime($startDate));
        $endDate = date("Y-m-d", strtotime($endDate));
    
        return $date >= $startDate && $date <= $endDate;
    }

    public function see_customer($id){
        $discount_acc_id = Bankacc::where('type', 'Discount')->pluck('id');
        $discountids = "(";
        foreach($discount_acc_id as $r){
            $discountids .= $r.",";
        }
        $discountids = substr($discountids, 0, -1);
        $discountids .= ")";
        
        $customer = Customer::where('id', $id)
                            ->select('customers.*')
                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(total_due) FROM sales WHERE customer_id = customers.id AND status = 1), 0) - COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND ref_tranx_id = "0"), 0)) as total_due'))

                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND account_id NOT IN '.$discountids.'), 0)) as total_pay'))

                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(total_due) FROM sales WHERE customer_id = customers.id AND status = 1 AND date >="'.$this->fysd.'" AND date <="'.$this->fyed.'"), 0) - COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND ref_tranx_id = "0" AND tranx_date >="'.$this->fysd.'" AND tranx_date <="'.$this->fyed.'"), 0)) as cy_due'))

                            ->addSelect(DB::raw('(COALESCE((SELECT SUM(amount) FROM account_tranxes WHERE ref_id = customers.id AND ref_type = "customer" AND tranx_date >="'.$this->fysd.'" AND tranx_date <="'.$this->fyed.'" AND account_id NOT IN '.$discountids.'), 0)) as cy_pay'))
                            ->get();
        $cs = Sales::where('customer_id', $id)
                    // ->whereBetween('date', [$this->fysd, $this->fyed])
                    ->where('order_type', 'sales')
                    ->where('status', 1)
                    ->get();
        $total_quantity = 0;
        $quantity = 0;
        for($i=0; $i<count($cs); $i++){
            $cyq = $this->isDateBetween($cs[$i]->date, $this->fysd, $this->fyed);
            $q = json_decode($cs[$i]->products);
            for($j=0; $j<count($q); $j++){
                $total_quantity += $q[$j]->quantity;
                $quantity += $cyq ? $q[$j]->quantity : 0;
            }
        }
        // dd($quantity);

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
                            ->where('ref_type', 'customer')
                            ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                            ->latest()->paginate(10)->withQueryString();
        }else{
            $datas = AccountTranx::join('bankaccs', 'account_tranxes.account_id', '=', 'bankaccs.id')
                    ->where('ref_id', $id)
                    ->where('ref_type', 'customer')
                    ->select('account_tranxes.*', 'bankaccs.name as bank_name')
                    ->latest()->paginate(10)->withQueryString();
        }
        return view('admin.customer.details', compact('customer', 'total_quantity', 'quantity', 'banks', 'datas'))->with('i', (request()->input('page', 1) - 1) * 10);
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
            $customer = Customer::findOrFail($request->input('ref_id'));
            // if($customer){
            //     $customer->balance = $customer->balance - $request->input('amount');
            //     $customer->save();
            // }
    
            if(!empty($request->input('id'))){
                $data = AccountTranx::where('id', $request->input('id'))
                                    ->where('ref_id', $request->input('ref_id'))
                                    ->where('ref_type', $request->input('ref_type'))
                                    ->get();
                
                $input = $request->all();
                $input['user_id'] = Auth::id();
                $input['note'] = $input['note'] . ' (Edited)';
                $data[0]->fill($input)->save();
            }else{
                $data = new AccountTranx();

                $input = $request->all();
                $input['user_id'] = Auth::id();
                
                $data->fill($input)->save();
            }
            

            if($request->input('sms_flag') == 'yes'){
                $sms = new SendSms();
                $sms->toSms($customer->mobile, config('app.name'). ' receive your payment BDT '. $input['amount'] .'. Thank you');
            }

            if(!empty($request->input('id')))
                flash()->addSuccess('Data Update Successfully.');
            else
                flash()->addSuccess('New Data Added Successfully.');
            // If all queries succeed, commit the transaction
            DB::commit();
        }catch (\Exception $e) {
            dd($e);
            // If any query fails, catch the exception and roll back the transaction
            flash()->addError('Data Not Added or Update Successfully.');
            DB::rollback();
        }
        return redirect($request->input('redirect_url'));
    }

    public function customer_tnx_edit($id){
        $order = AccountTranx::findOrFail($id);
        $account = Bankacc::all();
        return view('admin.customer.register_edit', compact('order', 'account'));
    }
    
    public function customer_tnx_delete($id){
        try{
            DB::beginTransaction();
            AccountTranx::where('id', $id)->delete();
            flash()->addSuccess('Customer Transection Deleted Successfully.');
            DB::commit();
        }catch (\Exception $e) {
            dd($e);
            flash()->addError('Customer Transection Unable To Delete');
            DB::rollback();
            return redirect('customer');
        }
        
        return redirect("customer");
    }
}
