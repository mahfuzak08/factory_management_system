<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Products;
use App\Models\Variants;


class InventoryController extends Controller
{
    public function category(){
        $categories = Category::all();
        return view('admin.inventory.category.manage', compact('categories'));
    }
    
    public function add_category(){
        $categories = Category::all();
        if(! empty(request()->input('id'))){
            $category = Category::findOrFail(request()->input('id'));
            return view('admin.inventory.category.edit', compact('categories', 'category'));
        }
        return view('admin.inventory.category.addnew', compact('categories'));
    }

    public function save_category(Request $request){
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'parent' => ['numeric']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_category');
        }

        if(!empty($request->input('id'))){
            $data = Category::findOrFail(request()->input('id'));
        }else{
            $data = new Category();
        }
        $input = $request->all();
        $data->fill($input)->save();
        flash()->addSuccess('Category Added/ Update Successfully.');
        return redirect('category');
    }
    
    public function products(){
        $products = Products::all();
        return view('admin.inventory.product.manage', compact('products'));
    }
    
    public function add_item(){
        $products = Products::all();
        $categories = Category::all();
        if(! empty(request()->input('id'))){
            $product = Products::findOrFail(request()->input('id'));
            return view('admin.inventory.product.edit', compact('products', 'product'));
        }
        return view('admin.inventory.product.addnew', compact('products', 'categories'));
    }

    public function save_item(Request $request){
        // dd($request->all());
        $input = $request->all();
        if(empty($request->input('size_check')) && !empty($request->input('qty'))){
            $input['sizes'][0] = $request->input('size');
            $input['qtys'][0] = $request->input('qty');
            $input['buyprices'][0] = $request->input('buyprice');
            $input['saleprices'][0] = $request->input('saleprice');
        }
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'category_id' => ['required', 'exists:categories,id'],
            'qtys.*' => ['required_without_all:array'],
        ];
        $custom_msg = [
            'qtys.*.required_without_all' => 'At least one quantity must be provided.'
        ];
        $validator = Validator::make($input, $rules, $custom_msg);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) { 
                flash()->addError($value[0]);
            }
            return redirect('add_item');
        }
        // dd($input);
        try{
            DB::beginTransaction();
            $input['user_id'] = Auth::id();
            if(!empty($request->input('id'))){
                $data = Products::findOrFail(request()->input('id'));
            }else{
                $data = new Products();
            }
            
            $data->fill($input)->save();
            $pt = array();
            foreach($input['qtys'] as $k=>$v){
                $vi = array(
                    'product_id' => $data->id,
                    'color' => @$input['colors'][$k],
                    'size' => @$input['sizes'][$k],
                    'sell_price' => @$input['saleprices'][$k],
                    'buy_price' => @$input['buyprices'][$k],
                );
                $vdata = new Variants();
                $vdata->fill($vi)->save();
                $pt[] = array($v, $vdata->id);
            }

            if(!empty($input['slno'])){
                $slnos = explode(";", $input['slno']);
                
            }

            flash()->addSuccess('Products Added/ Update Successfully.');
            
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            dd($e);
            flash()->addError('Fund Received Not Added Successfully.');
            DB::rollback();
        }
        
        return redirect('category');
    }
}
