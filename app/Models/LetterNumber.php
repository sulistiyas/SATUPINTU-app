<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LetterNumber extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'letter_number';
    protected $primaryKey = 'id_letter';
    protected $fillable = [
        'nomor_surat',
        'nomor_urut',
        'tipe_srt',
        'comp',
        'kode_client',
        'nama_perusahaan',
        'bln',
        'thn',
        'username',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];
}
