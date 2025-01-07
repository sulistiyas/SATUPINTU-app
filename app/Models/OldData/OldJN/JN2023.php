<?php

namespace App\Models\OldData\OldJN;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JN2023 extends Model
{
    use HasFactory;

    public $table = 'jn_2023';
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
}
