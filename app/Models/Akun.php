<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = "akuns";

    protected $fillable = [
        'usaha_id',
        'paket_id',
        'order_no',
        'status',
        'biaya',
        'durasi',
        'keterangan',
        'start_date',
        'expire_date',
    ];

    public function paket()
    {
        return $this->hasOne(Paket::class, 'id', 'paket_id');
    }


}
