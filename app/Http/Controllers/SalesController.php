<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Sales;
use App\Models\Customer;

class SalesController extends Controller
{
    public function index(){
        $account = Bankacc::all();
        $customer = Customer::where('is_delete', 0)->get();
        return view('admin.sales.register', compact('customer', 'account'));
    }

    public function set_sales(Request $request){
        $rules = [
            'customer_new' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total' => ['required', 'integer']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('sales');
        }
        $customer_id = $request->input('customer_id');
        $asofdue = 0;
        if($request->input('customer_id') == null){
            if($request->input('mobile') == null){
                flash()->addError('Mobile number is required.');
                return redirect('sales');
            }
            DB::beginTransaction();
            try{
                $vinfo = new Customer();
                
                $input = ["name"=>$request->input("customer_new"), "address"=>$request->input('address'), "mobile"=>$request->input('mobile')];
                
                $vinfo->fill($input)->save();
        
                $customer_id = $vinfo->id;
                // $cash_acc_id = Bankacc::where('type', 'Cash')->pluck('id');
                // $trnxdata = [
                //     'account_id' => $cash_acc_id[0],
                //     'user_id' => Auth::id(),
                //     'tranx_date' => date("Y-m-d"),
                //     'ref_id' => $customer_id,
                //     'ref_type' => 'customer',
                //     'note' => 'Customer Opening Due Balance',
                //     'amount' => 0
                // ];
                // $tdata = new AccountTranx();
                // $tdata->fill($trnxdata)->save();

                flash()->addSuccess('New Customer Added Successfully.');
                // If all queries succeed, commit the transaction
                DB::commit();
            }catch (\Exception $e) {
                // If any query fails, catch the exception and roll back the transaction
                flash()->addError('Customer Not Added Successfully.');
                DB::rollback();
                return redirect('sales');
            }
        }else{
            $vinfo = Customer::findOrFail($customer_id);
            $asofdue = $vinfo->balance;
        }
        // dd($customer_id);
        $due_acc_id = Bankacc::where('type', 'Due')->pluck('id');
        
        $pn = $request->input('product_name');
        $qty = $request->input('quantity');
        $price = $request->input('price');
        $pid = $request->input('product_id');
        $ptype = $request->input('payment_type');
        $receive_amount = $request->input('receive_amount');
        
        $items = array();
        $payments = array();
        $total = 0;
        
        for($i=0; $i<count($pn); $i++){
            $items[] = [
                "pid"=>$pid[$i],
                "product_name"=>$pn[$i], 
                "quantity"=>(float) $qty[$i],
                "price"=>(float) $price[$i],
                "total"=>(float) $qty[$i] * (float) $price[$i] 
            ];
            $total += (float) $qty[$i] * (float) $price[$i];
        }
        
        for($i=0; $i<count($ptype); $i++){
            $payments[] = [
                "pid"=>$ptype[$i],
                "receive_amount"=>(float) $receive_amount[$i]
            ];
            if(count($due_acc_id) > 0 && $ptype[$i] == $due_acc_id[0])
                $asofdue += (float) $receive_amount[$i];
        }

        $discount = (float) $request->input('discount');
        $total -= $discount;
        $moid = Sales::max("order_id");
        
        $input_order = [
            "order_id"=> $moid > 0 ? $moid+1 : 786,
            "order_type"=> "sales",
            "user_id"=> Auth::id(),
            "customer_id"=> $customer_id,
            "products"=> json_encode($items),
            "date"=> $request->input('date'),
            "discount"=> $discount,
            "total"=> $total,
            "payment"=> json_encode($payments),
            "asof_date_due"=> $asofdue,
        ];
        
        try{
            DB::beginTransaction();
            
            $order = New Sales();
            $order->fill($input_order)->save();
            $order_id = $order->id; 
            
            $vinfo->balance = $asofdue;
            $vinfo->save();

            for($i=0; $i<count($ptype); $i++){
                if(count($due_acc_id) > 0 && $ptype[$i] == $due_acc_id[0]) continue;

                $trnxdata = [
                    'account_id' => $ptype[$i],
                    'user_id' => Auth::id(),
                    'tranx_date' => $request->input('date'),
                    'ref_id' => $customer_id,
                    'ref_type' => 'customer',
                    'ref_tranx_id' => $order_id,
                    'ref_tranx_type' => 'sales_order',
                    'note' => '',
                    'amount' => (float) $receive_amount[$i]
                ];
                $tdata = new AccountTranx();
                $tdata->fill($trnxdata)->save();
            }

            flash()->addSuccess('Sales Order Added Successfully.');
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            dd($e);
            flash()->addError('Sales Order Not Added Successfully.');
            DB::rollback();
            return redirect('sales');
        }

        return redirect("sales_invoice/$order_id");
    }

    public function invoice($id){
        $invoice = Sales::join("customers", "sales.customer_id", "=", "customers.id")
                            ->select('sales.*', 'customers.name as customer_name', 'customers.mobile', 'customers.address')
                            ->where("sales.id", $id)
                            ->get();
        $account = Bankacc::all();
        // $customer = Customer::where('is_delete', 0)->get();
        return view('admin.sales.invoice', compact('invoice', 'account'));
    }
}
