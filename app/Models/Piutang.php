<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Piutang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'nota_id',
        'no_nota',
        'tanggal',
        'jumlah',
        'status',
        'user_id'
    ];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }

}
