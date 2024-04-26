<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'client';
    protected $primaryKey = 'id_client';
    protected $fillable = [
        'nama_perusahaan',
        'almt_perusahaan',
        'npwp',
        'almt_npwp',
        'kodepos',
        'kota',
        'nama_up',
        'jabatan_up',
        'phone',
        'username',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
