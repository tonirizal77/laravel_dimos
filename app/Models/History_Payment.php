<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class History_Payment extends Model
{
    use HasFactory;

    protected $table = 'history_payments';

    protected $fillable = [
        'order_no',
        'keterangan',
    ];

    //relationship
    public function Order()
    {
        return $this->hasOne(Order_Paket::class, 'id','order_no');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}
