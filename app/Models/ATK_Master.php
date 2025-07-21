<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ATK_Master extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'atk_master';
    protected $primaryKey = 'id_atk';
    protected $fillable = [
        'atk_name',
        'atk_brand',
        'atk_stock',
        'atk_unit',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function atkRequestLogs()
    {
        return $this->hasMany(ATK_Request_Log::class, 'atk_id', 'id_atk');
    }

    
}
