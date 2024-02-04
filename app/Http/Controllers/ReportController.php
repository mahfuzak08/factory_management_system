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
use App\Models\Sales;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Expense_detail;
// use App\Models\Vendor;

class ReportController extends Controller
{
    public function sales(Request $request){
        $sd = request()->input('start_date');
        $ed = request()->input('end_date');
        $cid = request()->input('customer_id');
        $inv = request()->input('inv_id');
        $status = request()->input('status');
        $total = array();
        if(! empty($sd) || ! empty($ed) || ! empty($cid) || ! empty($inv)){
            $datas = Sales::join("customers", "sales.customer_id", "=", "customers.id")
                                ->select('sales.*', 'customers.name as customer_name')
                                ->where(function($q) use($status, $sd, $ed, $cid, $inv){
                                    if($status != 'all')
                                        $q->where('status', $status);
                                    if($inv != '') {
                                        $q->where('order_id', $inv);
                                    }
                                    else{
                                        if($sd && $ed)
                                            $q->where('date', '>=', $sd)->where('date', '<=', $ed);

                                        if($cid != 'all') {
                                            $q->where('customer_id', $cid);
                                        }
                                    }
                                })
                                ->paginate(10)->withQueryString();
                if ($datas->hasMorePages()) {

                }else{
                    $total = Sales::where(function($q) use($status, $sd, $ed, $cid, $inv){
                        if($status != 'all')
                            $q->where('status', $status);
                        if($inv != '') {
                            $q->where('order_id', $inv);
                        }
                        else{
                            if($sd && $ed)
                                $q->where('date', '>=', $sd)->where('date', '<=', $ed);

                            if($cid != 'all') {
                                $q->where('customer_id', $cid);
                            }
                        }
                    })
                    ->selectRaw('sum(total) as total, sum(total_due) as total_due')
                    ->get();
                }
        }else{
            $datas = Sales::join("customers", "sales.customer_id", "=", "customers.id")
                                ->select('sales.*', 'customers.name as customer_name')
                                ->where('status', 1)
                                ->where('date', '>=', date('Y-m-d'))
                                ->where('date', '<=', date('Y-m-d'))
                                ->paginate(10)->withQueryString();
            if ($datas->hasMorePages()) {

            } else {
                $total = Sales::where('status', 1)
                            ->where('date', '>=', date('Y-m-d'))
                            ->where('date', '<=', date('Y-m-d'))
                            ->selectRaw('sum(total) as total, sum(total_due) as total_due')
                            ->get();
            }
        }
        $account = Bankacc::all();
        $customer = Customer::all();

        return view('admin.report.sales', compact('datas', 'total', 'account', 'customer'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function purchase(){
        $sd = request()->input('start_date');
        $ed = request()->input('end_date');
        $vid = request()->input('vendor_id');
        $inv = request()->input('inv_id');
        $status = request()->input('status');
        $total = array();
        if(! empty($sd) || ! empty($ed) || ! empty($cid) || ! empty($inv)){
            $datas = Purchase::join("vendors", "purchases.vendor_id", "=", "vendors.id")
                                ->select('purchases.*', 'vendors.name as vendor_name')
                                ->where(function($q) use($status, $sd, $ed, $vid, $inv){
                                    if($status != 'all')
                                        $q->where('status', $status);
                                    if($inv != '') {
                                        $q->where('order_id', $inv);
                                    }
                                    else{
                                        if($sd && $ed)
                                            $q->where('date', '>=', $sd)->where('date', '<=', $ed);

                                        if($vid != 'all') {
                                            $q->where('vendor_id', $vid);
                                        }
                                    }
                                })
                                ->paginate(10)->withQueryString();
            if ($datas->hasMorePages()) {
                
            }else{
                $total = Purchase::where(function($q) use($status, $sd, $ed, $vid, $inv){
                    if($status != 'all')
                        $q->where('status', $status);
                    if($inv != '') {
                        $q->where('order_id', $inv);
                    }
                    else{
                        if($sd && $ed)
                            $q->where('date', '>=', $sd)->where('date', '<=', $ed);

                        if($vid != 'all') {
                            $q->where('vendor_id', $vid);
                        }
                    }
                })
                ->selectRaw('sum(total) as total, sum(total_due) as total_due')
                ->get();
            }
        }else{
            $datas = Purchase::join("vendors", "purchases.vendor_id", "=", "vendors.id")
                            ->select('purchases.*', 'vendors.name as vendor_name')
                            ->where('status', 1)
                            ->where('date', '>=', date('Y-m-d'))
                            ->where('date', '<=', date('Y-m-d'))
                            ->paginate(10)->withQueryString();
            if ($datas->hasMorePages()) {

            } else {
                $total = Purchase::where('status', 1)
                            ->where('date', '>=', date('Y-m-d'))
                            ->where('date', '<=', date('Y-m-d'))
                            ->selectRaw('sum(total) as total, sum(total_due) as total_due')
                            ->get();
            }
        }
        
        $account = Bankacc::all();
        $vendor = Vendor::all();

        return view('admin.report.purchase', compact('datas', 'total', 'account', 'vendor'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function expense(Request $request){
        if(! empty(request()->input('start_date'))){
            $sd = request()->input('start_date');
            $ed = request()->input('end_date');
            $expenseType = request()->input('expense_type');
            
            $datas = Expense_detail::join("expenses", "expense_details.expense_id", "=", "expenses.id")
                                ->join("bankaccs", "expense_details.account_id", "=", "bankaccs.id")
                                ->select("expense_details.*", "expenses.name as expense_name", "bankaccs.name as acc_name")
                                ->where(function ($q) use ($sd, $ed, $expenseType) {
                                    if(! empty($sd) && ! empty($ed)){
                                        $q->where('trnx_date', '>=', $sd)
                                            ->where('trnx_date', '<=', $ed);
                                    }
                                    if ($expenseType != 'all') {
                                        $q->where('expense_id', $expenseType);
                                    }
                                })
                                ->paginate(10)->withQueryString();

            if(! $datas->hasMorePages()){
                $etotal = Expense_detail::where(function ($q) use ($sd, $ed, $expenseType) {
                                            if(! empty($sd) && ! empty($ed)){
                                                $q->where('trnx_date', '>=', $sd)
                                                    ->where('trnx_date', '<=', $ed);
                                            }
                                            if ($expenseType != 'all') {
                                                $q->where('expense_id', $expenseType);
                                            }
                                        })->sum('amount');
            }
            else{
                $etotal = 0;
            }
        }else{
            $datas = Expense_detail::join("expenses", "expense_details.expense_id", "=", "expenses.id")
                                ->join("bankaccs", "expense_details.account_id", "=", "bankaccs.id")
                                ->select("expense_details.*", "expenses.name as expense_name", "bankaccs.name as acc_name")
                                ->where('trnx_date', '>=', date('Y-m-d'))
                                ->where('trnx_date', '<=', date('Y-m-d'))
                                ->paginate(10)->withQueryString();

            if(! $datas->hasMorePages()){
                $etotal = Expense_detail::where('trnx_date', '>=', date('Y-m-d'))
                                        ->where('trnx_date', '<=', date('Y-m-d'))
                                        ->sum('amount');
            }
            else{
                $etotal = 0;
            }
        }
        $expense = Expense::all();

        return view('admin.report.expense', compact('datas', 'expense', 'etotal'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function profit_and_loss(Request $request){
        $total['expense'] = []; 
        $total['purchase'] = 0; 
        $total['sales'] = 0;
        $total['salary'] = 0;
        $total['discount'] = 0;
        $total['pay'] = 0;
        $total['receive'] = 0;
        $total['accounts_bal'] = [];
        $quantity = 0;
        $start_date = "";
        $end_date = "";

        if(! empty(request()->input('start_date'))){
            $sd = request()->input('start_date');
            $ed = empty(request()->input('end_date')) ? date("Y-m-d") : request()->input('end_date');
            $start_date = $sd;
            $end_date = $ed;
            
            $total['expense'] = Expense_detail::join("expenses", "expense_details.expense_id", "=", "expenses.id")
                                ->where('expense_details.trnx_date', '>=', $sd)
                                ->where('expense_details.trnx_date', '<=', $ed)
                                ->where('expenses.status', '=', 1)
                                ->groupBy('expense_details.expense_id', 'expenses.name')
                                ->select('expense_details.expense_id', 'expenses.name as expense_name', \DB::raw('SUM(expense_details.amount) as total_amount'))
                                ->get();
            $total['salary'] = AccountTranx::where('tranx_date', '>=', $sd)
                                    ->where('tranx_date', '<=', $ed)
                                    ->where('ref_type', 'employee')
                                    ->sum('amount');

            $discount_acc_id = Bankacc::where('type', 'Discount')->pluck('id');
            $total['discount'] = AccountTranx::where('tranx_date', '>=', $sd)
                                    ->where('tranx_date', '<=', $ed)
                                    ->where('account_id', $discount_acc_id[0])
                                    ->sum('amount');
            $total['receive'] = AccountTranx::where('tranx_date', '>=', $sd)
                                    ->where('tranx_date', '<=', $ed)
                                    ->where('ref_type', 'customer')
                                    ->sum('amount');
            $total['pay'] = AccountTranx::where('tranx_date', '>=', $sd)
                                    ->where('tranx_date', '<=', $ed)
                                    ->where('ref_type', 'vendor')
                                    ->sum('amount');
            $total['sales'] = Sales::where('date', '>=', $sd)
                                    ->where('date', '<=', $ed)
                                    ->where('order_type', 'sales')
                                    ->where('status', 1)
                                    ->sum('total');
            $tq = Sales::where('date', '>=', $sd)
                                    ->where('date', '<=', $ed)
                                    ->where('order_type', 'sales')
                                    ->where('status', 1)
                                    ->select('products')
                                    ->get();
            $quantity = 0;
            for($i=0; $i<count($tq); $i++){
                $q = json_decode($tq[$i]->products);
                for($j=0; $j<count($q); $j++)
                    $quantity += $q[$j]->quantity;
            }
            $total['purchase'] = Purchase::where('date', '>=', $sd)
                                    ->where('date', '<=', $ed)
                                    ->where('order_type', 'purchase')
                                    ->where('status', 1)
                                    ->sum('total');
            // $total['accounts_bal'] = AccountTranx::join("bankaccs", "account_tranxes.account_id", "=", "bankaccs.id")
            //                         ->where('account_tranxes.tranx_date', '>=', $sd)
            //                         ->where('account_tranxes.tranx_date', '<=', $ed)
            //                         ->groupBy('account_tranxes.account_id', 'bankaccs.name')
            //                         ->select('account_tranxes.account_id', 'bankaccs.name', \DB::raw('SUM(account_tranxes.amount) as bal'))
            //                         ->get();

        }
        return view('admin.report.profitnloss', compact('total', 'start_date', 'end_date', 'quantity'));
    }
}
