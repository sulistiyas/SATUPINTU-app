<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OldJobnumber extends Model
{
    // use HasFactory;
    use SoftDeletes;
    public $table = 'old_jobnumber';
    protected $primaryKey = 'id_jn';
    protected $fillable = [
        'id_client',
        'bulan',
        'job_number',
        'contract_no',
        'amount',
        'program',
        'c_p',
        'hours',
        'pic',
        'instructor',
        'day_training',
        'day_training2',
        'starting_date',
        'ending_date',
        'teacher_comp',
        'total_manday',
        'remarks',
        'username',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
