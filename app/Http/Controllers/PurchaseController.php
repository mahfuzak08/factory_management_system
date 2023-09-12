<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Purchase;
use App\Models\Vendor;

class PurchaseController extends Controller
{
    public function index(){
        $account = Bankacc::all();
        $vendor = Vendor::where('is_delete', 0)->get();
        return view('admin.purchase.register', compact('vendor', 'account'));
    }
    
    public function set_purchase(Request $request){
        $rules = [
            'vendor_new' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total' => ['required', 'integer']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('purchase');
        }
        $vendor_id = $request->input('vendor_id');
        $asofdue = 0;
        if($request->input('vendor_id') == null){
            // dd($request->input('vendor_id') == null);
            // exit();
            if($request->input('mobile') == null){
                flash()->addError('Mobile number is required.');
                return redirect('purchase');
            }
            DB::beginTransaction();
            try{
                $vinfo = new Vendor();
                
                $input = ["name"=>$request->input("vendor_new"), "address"=>$request->input('address'), "mobile"=>$request->input('mobile')];
                
                $vinfo->fill($input)->save();
        
                $vendor_id = $vinfo->id;
                $cash_acc_id = Bankacc::where('type', 'Cash')->pluck('id');
                $trnxdata = [
                    'account_id' => $cash_acc_id[0],
                    'user_id' => Auth::id(),
                    'tranx_date' => date("Y-m-d"),
                    'ref_id' => $vendor_id,
                    'ref_type' => 'vendor',
                    'note' => 'Vendor Opening Due Balance',
                    'amount' => 0
                ];
                $tdata = new AccountTranx();
                $tdata->fill($trnxdata)->save();

                flash()->addSuccess('New Vendor Added Successfully.');
                // If all queries succeed, commit the transaction
                DB::commit();
            }catch (\Exception $e) {
                // If any query fails, catch the exception and roll back the transaction
                flash()->addError('Vendor Not Added Successfully.');
                DB::rollback();
                return redirect('purchase');
            }
        }else{
            $vinfo = Vendor::findOrFail($vendor_id);
            $asofdue = $vinfo->balance;
        }
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

        $input_order = [
            "order_id"=> Purchase::max("order_id") || 786,
            "order_type"=> "purchase",
            "user_id"=> Auth::id(),
            "vendor_id"=> $vendor_id,
            "products"=> json_encode($items),
            "date"=> $request->input('date'),
            "vendor_id"=> $vendor_id,
            "discount"=> $discount,
            "total"=> $total,
            "payment"=> json_encode($payments),
            "asof_date_due"=> $asofdue,
        ];

        try{
            DB::beginTransaction();

            $order = New Purchase();
            $order->fill($input_order)->save();
            $order_id = $order->id; 
            for($i=0; $i<count($ptype); $i++){
                if($ptype[$i] == $due_acc_id[0]) continue;

                $trnxdata = [
                    'account_id' => $ptype[$i],
                    'user_id' => Auth::id(),
                    'tranx_date' => $request->input('date'),
                    'ref_id' => $order_id,
                    'ref_type' => 'purchase_order',
                    'note' => '',
                    'amount' => (float) $receive_amount[$i] * -1
                ];
                $tdata = new AccountTranx();
                $tdata->fill($trnxdata)->save();
            }

            flash()->addSuccess('Purchase Order Added Successfully.');
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            dd($e);
            flash()->addError('Purchase Order Not Added Successfully.');
            DB::rollback();
            return redirect('purchase');
        }

        return redirect("purchase_invoice/$order_id");
    }

    public function invoice($id){
        $invoice = Purchase::findOrFail($id);
        // $account = Bankacc::all();
        // $vendor = Vendor::where('is_delete', 0)->get();
        return view('admin.purchase.invoice', compact('invoice'));
    }
}
