<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sesijual extends Model
{
    use HasFactory;

    protected $table = null;

    protected $fillable = [
        'kode_sesi','tanggal','user_id','kas_awal',
        'total','tunai','kartu','kredit','diskon','setoran',
        'k100000','k50000','k20000','k10000','k5000',
        'k1000','k500','l1000','l500','l100','l50'
    ];

    /**
     * buka table dinamis
     */
    /**
     * syntax for function scopeTable
     * syntax: 1
     * - $query->getQuery()->from = $tableName
     * - return $query
     * used: query()->table('')

     * syntax: 2
     * - return $query->from($tableName)
     * used: from('')
     */


    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }

    //relationship
    // public function food()
    // {
    //     return $this->hasOne(Food::class, 'id','food_id');
    // }

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
