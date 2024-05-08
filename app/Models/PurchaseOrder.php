<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'po';
    protected $primaryKey = 'id_po';
    protected $fillable = [
        'po_no',
        'id_jn',
        'id_employee',
        'po_desc',
        'po_qty',
        'po_unit',
        'po_status',
        'po_date',
        'id_manager',
        'po_reason',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
