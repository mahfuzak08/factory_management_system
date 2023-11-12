<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use App\Models\AccountTranx;
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
        }else{
            $datas = Sales::join("customers", "sales.customer_id", "=", "customers.id")
                                ->select('sales.*', 'customers.name as customer_name')
                                ->where('status', 1)
                                ->where('date', '>=', date('Y-m-d'))
                                ->where('date', '<=', date('Y-m-d'))
                                ->paginate(10)->withQueryString();
        }
        $account = Bankacc::all();
        $customer = Customer::all();

        return view('admin.report.sales', compact('datas', 'account', 'customer'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function purchase(){
        $sd = request()->input('start_date');
        $ed = request()->input('end_date');
        $vid = request()->input('vendor_id');
        $inv = request()->input('inv_id');
        $status = request()->input('status');
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
        }else{
            $datas = Purchase::join("vendors", "purchases.vendor_id", "=", "vendors.id")
                            ->select('purchases.*', 'vendors.name as vendor_name')
                            ->where('status', 1)
                            ->where('date', '>=', date('Y-m-d'))
                            ->where('date', '<=', date('Y-m-d'))
                            ->paginate(10)->withQueryString();
        }

        $account = Bankacc::all();
        $vendor = Vendor::all();

        return view('admin.report.purchase', compact('datas', 'account', 'vendor'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        }else{
            $datas = Expense_detail::join("expenses", "expense_details.expense_id", "=", "expenses.id")
                                ->join("bankaccs", "expense_details.account_id", "=", "bankaccs.id")
                                ->select("expense_details.*", "expenses.name as expense_name", "bankaccs.name as acc_name")
                                ->where('trnx_date', '>=', date('Y-m-d'))
                                ->where('trnx_date', '<=', date('Y-m-d'))
                                ->paginate(10)->withQueryString();
        }
        $expense = Expense::all();

        return view('admin.report.expense', compact('datas', 'expense'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
