<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office_Asset extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'office_asset';
    protected $primaryKey = 'id_asset';
    protected $fillable = [
        'asset_code',
        'id_device',
        'qty',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'price',
        'kondisi',
        'id_employee',
        'device_location',
        'desc',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
