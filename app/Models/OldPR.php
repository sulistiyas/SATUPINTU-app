<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldPR extends Model
{
    use HasFactory;
    public $table = 'tbl_pr';
    protected $primaryKey = 'id_pr';
}
