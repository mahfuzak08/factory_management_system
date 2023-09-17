<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mobile', 'gender', 'address', 'nid', 'image', 'salary', 'bonus', 'emp_type', 'joining', 'closing'];
}
