<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ATK_Request_Log extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'atk_request_id';

    protected $table = 'atk_request_log';

    protected $fillable = [
        'user_id',
        'atk_id',
        'request_date',
        'status',
        'remarks',
        'quantity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atk()
    {
        return $this->belongsTo(ATK_Master::class, 'atk_id');
    }

    
}
