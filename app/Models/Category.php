<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent',
    ];
    // If you want timestamps, remove this line
    public $timestamps = false;
    // Add relationships if needed
    public function parentCategory() {
        return $this->belongsTo(Category::class, 'parent');
    }
    public function children() {
        return $this->hasMany(Category::class, 'parent');
    }
}
