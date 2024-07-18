<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device_Master extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'device_master';
    protected $primaryKey = 'id_device';
    protected $fillable = [
        'device_name'
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
