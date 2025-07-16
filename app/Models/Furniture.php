<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Furniture extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'furniture';
    protected $primaryKey = 'id_furniture';
    protected $fillable = ['item_name', 'quantity', 'condition','location','furniture_image'];

}
