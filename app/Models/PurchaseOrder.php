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
        'id_pr',
        'id_vendor',
        'currency',
        'price',
        'total_price',
        'po_date',
        'po_status',
        'po_approve',
        'po_disc_type',
        'po_disc',
        'po_tax',
        'po_service_charge',
        'po_delivery_fee',
        'po_additional_charge',
        'po_rev',

    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
