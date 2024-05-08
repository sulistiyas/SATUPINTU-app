<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'pr';
    protected $primaryKey = 'id_pr';
    protected $fillable = [
        'pr_no',
        'id_jn',
        'id_employee',
        'pr_desc',
        'pr_qty',
        'pr_unit',
        'pr_status',
        'pr_date',
        'id_manager',
        'pr_reason',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
