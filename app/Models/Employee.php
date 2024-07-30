<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'employee';
    protected $primaryKey = 'id_employee';

    protected $fillable = [
        'id_users',
        'personal_email',
        'emp_position',
        'emp_division',
        'place_birth',
        'birth_date',
        'sex',
        'nik',
        'npwp',
        'bank_acc',
        'bpjs_kes',
        'bpjs_ket',
        'date_joined',
        'status_kontrak',
        'status_nikah',
        'emp_address',
        'emp_phone',
        'emp_phone_emergency',
    ];

        protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
