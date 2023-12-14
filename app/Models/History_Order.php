<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class History_Order extends Model
{
    use HasFactory;
    // use SoftDeletes;

    //harus dibuat karna ada tanda (_ underscor)
    protected $table = "history_order";

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
