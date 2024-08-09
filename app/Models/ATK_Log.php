<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ATK_Log extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'atk_log';
    protected $primaryKey = 'id_atk_log';
    protected $fillable = [
        'log_type',
        'id_atk',
        'qty_log',
        'date_log',
        'time_log',
        'id_employee',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
