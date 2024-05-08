<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'vendor';
    protected $primaryKey = 'id_vendor';
    protected $fillable = [
        'vendor',
        'vendor_cp',
        'telepon',
        'email',
        'alamat',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
