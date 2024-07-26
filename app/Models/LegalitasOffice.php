<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalitasOffice extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'legalitas_office';
    protected $primaryKey = 'id_legalitas';
    protected $fillable = [
        'no_legalitas',
        'dokumen',
        'nama_perusahaan',
        'terbit',
        'berakhir',
        'status',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
