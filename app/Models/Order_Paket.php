<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Paket extends Model
{
    use HasFactory;

    protected $table = 'order_pakets';

    protected $fillable = [
        'order_no',
        'paket_id',
        'usaha_id',
        'durasi',
        'total',
        'order_status',
        'payment_status',
        'snap_token'
    ];

    // relationship
    public function paket()
    {
        return $this->hasOne(Paket::class, 'id','paket_id');
    }

    public function usaha()
    {
        return $this->hasOne(Usaha::class, 'id','usaha_id');
    }
}
