<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Bankacc;


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
}
