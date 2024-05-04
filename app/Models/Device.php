<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Device extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['name', 'ip', 'port', 'status'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
