<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Nota_Jual extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $table = null;

    // protected $fillable = [
    //     'data',
    // ];

    // protected $casts = [
    //     'data' => 'object',
    // ];

    protected $fillable = [
        'no_nota', 'tanggal', 'customer_id', 'brutto', 'disc', 'total',
        'tunai', 'kredit', 'kartu', 'tempo', 'tgl_tempo', 'user_id'
    ];

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

    // public function user()
    // {
    //     return $this->hasOne(User::class, 'id','user_id');
    // }
}

