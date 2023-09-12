<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTranx extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'tranx_date', 'ref_id','ref_type', 'ref_tranx_id', 'ref_tranx_type', 'amount','user_id', 'note'];
}
