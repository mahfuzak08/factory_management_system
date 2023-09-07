<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankacc extends Model
{
    use HasFactory;

    protected $fillable = ['name','type','bank_name','bank_address','acc_no', 'currency'];

    
}
