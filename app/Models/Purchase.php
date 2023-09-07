<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'order_type', 'user_id','vendor_id','products','return_items', 'date', 'status', 'discount_code', 'shipping_cost','labour_cost','carrying_cost','other_cost', 'total', 'asof_date_due', 'note'];
}
