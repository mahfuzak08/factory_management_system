<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Bankacc;
use App\Models\Category;
use App\Models\Product;
use App\Models\Product_tranx;
use App\Models\Purchase;
use App\Models\Tags;
use App\Models\Variant;
use App\Models\Vendor;


class InventoryController extends Controller
{
    public function autocomplete_product_search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::select('products.*', 'categories.name as category_name', 'variants.id as variant_id', 'variants.sell_price as price', 'variants.size', 'variants.color')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('variants', 'products.id', '=', 'variants.product_id')
            ->where('products.name', 'LIKE', "%$query%")
            ->orWhere('products.barcode', 'LIKE', "%$query%")
            ->orWhere('products.brand_name', 'LIKE', "%$query%")
            ->orWhere('products.description', 'LIKE', "%$query%")
            ->orWhere('products.tags', 'LIKE', "%$query%")
            ->orWhere('categories.name', 'LIKE', "%$query%")
            ->orWhere('variants.size', 'LIKE', "%$query%")
            ->get();

        return response()->json($products);
    }

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
        $products = Product::all();
        return view('admin.inventory.product.manage', compact('products'));
    }
    
    public function add_item(){
        $brands = Brand::all();
        $categories = Category::all();
        $products = Product::all();
        $tags = Tags::all();
        $vendors = Vendor::all();
        if(! empty(request()->input('id'))){
            $product = Product::findOrFail(request()->input('id'));
            return view('admin.inventory.product.edit', compact('products', 'product'));
        }
        return view('admin.inventory.product.addnew', compact('products', 'categories', 'vendors', 'brands', 'tags'));
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
                $data = Product::findOrFail(request()->input('id'));
            }else{
                $data = new Product();
            }
            
            $data->fill($input)->save();
            $product_id = $data->id;
            if(empty($input['barcode'])){
                $ui['barcode'] = $product_id;
                $data->fill($ui)->save();
            }
            $pt = array();
            foreach($input['qtys'] as $k=>$v){
                $vi = array(
                    'product_id' => $product_id,
                    'color' => @$input['colors'][$k],
                    'size' => @$input['sizes'][$k],
                    'sell_price' => @$input['saleprices'][$k],
                    'buy_price' => @$input['buyprices'][$k],
                );
                $vdata = new Variant();
                $vdata->fill($vi)->save();
                $pt[] = array($v, $vdata->id, @$input['buyprices'][$k]);
            }
            
            $items = array();
            $total = 0;
            $moid = Purchase::max("order_id");
            $order_id = $moid > 0 ? $moid+1 : 786;

            foreach($pt as $v){
                $pti = array(
                    'product_id' => $product_id,
                    'variant_id' => $v[1],
                    'order_id' => $order_id,
                    'order_type' => 'purchase',
                    'date' => $input['date'],
                    'inout' => 'in',
                    'qty' => $v[0],
                    'batch_no' => $input['batchno'],
                    'expiry_date' => $input['expirydate'],
                    'actual_buy_price' => $v[2],
                );
                $pdata = new Product_tranx();
                $pdata->fill($pti)->save();

                $items[] = [
                    "pid"=>$product_id,
                    "product_name"=>$input['name'], 
                    "product_details"=>$input['description'], 
                    "quantity"=>(float) $v[0],
                    "price"=>(float) $v[2],
                    "total"=>(float) $v[0] * (float) $v[2] 
                ];
                $total += (float) $v[0] * (float) $v[2];
            }

            if(!empty($input['brand_name'])){
                $bn = Brand::where("brand_name", $input['brand_name'])->pluck('id');
                if(count($bn) == 0){
                    $nb = new Brand();
                    $nb->fill(array("brand_name"=>$input['brand_name']))->save();
                }
            }
            
            if(!empty($input['tags'])){
                $tag_list = explode(";", $input['tags']);
                foreach($tag_list as $t){
                    $ht = Tags::where("tag_name", $t)->pluck('id');
                    if(count($ht) == 0){
                        $nt = new Tags();
                        $nt->fill(array("tag_name"=>$t))->save();
                    }
                }
            }

            ////////////////////////////////////////////////////////////
            $due_acc_id = Bankacc::where('type', 'Due')->pluck('id');
            $payments[] = [
                "pid"=>$due_acc_id[0],
                "receive_amount"=>(float) $total
            ];
            $due = (float) $total;

            $vendor_id = $input['vendor_id'];
            if($vendor_id == 0){
                $untitle_vendor_id = Vendor::where('name', 'Untitled Vendor')->pluck('id');
                if(count($untitle_vendor_id) == 0){
                    $vinfo = new Vendor();
                    $input = ["name"=>'Untitled Vendor', "address"=>'System Genarated', "mobile"=>'8800000000000'];
                    $vinfo->fill($input)->save();
                    $vendor_id = $vinfo->id;
                }
                else $vendor_id = $untitle_vendor_id[0];
            }

            $input_order = [
                "order_id"=> $order_id,
                "order_type"=> "purchase",
                "user_id"=> Auth::id(),
                "vendor_id"=> $vendor_id,
                "products"=> json_encode($items),
                "date"=> $input['date'],
                "discount"=> 0,
                "total"=> $total,
                "payment"=> json_encode($payments),
                "total_due"=> $due,
                "note"=> "system_genarated",
            ];

            $order = New Purchase();
            $order->fill($input_order)->save();
            
            
            ////////////////////////////////////////////////////////////////
            flash()->addSuccess('Products Added/ Update Successfully.');
            
            DB::commit();
        }catch (\Exception $e) {
            // If any query fails, catch the exception and roll back the transaction
            dd($e);
            flash()->addError('Fund Received Not Added Successfully.');
            DB::rollback();
        }
        
        return redirect('products');
    }
}
