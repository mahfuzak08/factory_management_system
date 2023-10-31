<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// use App\Models\AccountTranx;
use App\Models\Bankacc;
use App\Models\Purchase;
use App\Models\Sales;
use App\Models\Expense;
use App\Models\Expense_detail;
// use App\Models\Vendor;

class ReportController extends Controller
{
    public function sales(Request $request){
        if(! empty(request()->input('start_date'))){
            $sd = request()->input('start_date');
            $ed = request()->input('end_date');
        }else{
            $datas = Sales::join("customers", "sales.customer_id", "=", "customers.id")
                                ->select('sales.*', 'customers.name as customer_name')
                                ->paginate(10);
        }
        $account = Bankacc::all();

        return view('admin.sales.manage', compact('datas', 'account'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function purchase(){
        $datas = Purchase::join("vendors", "purchases.vendor_id", "=", "vendors.id")
                            ->select('purchases.*', 'vendors.name as vendor_name')
                            ->paginate(10);
        $account = Bankacc::all();

        return view('admin.purchase.manage', compact('datas', 'account'))->with('i', (request()->input('page', 1) - 1) * 10);
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
                                    $q->where('trnx_date', '>=', $sd)
                                        ->where('trnx_date', '<=', $ed);
                                    
                                    if ($expenseType != 'all') {
                                        $q->where('expense_id', $expenseType);
                                    }
                                })
                                ->paginate(10);
        }else{
            $datas = Expense_detail::join("expenses", "expense_details.expense_id", "=", "expenses.id")
                                ->join("bankaccs", "expense_details.account_id", "=", "bankaccs.id")
                                ->select("expense_details.*", "expenses.name as expense_name", "bankaccs.name as acc_name")
                                ->paginate(10);
        }
        $expense = Expense::all();

        return view('admin.report.expense', compact('datas', 'expense'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
