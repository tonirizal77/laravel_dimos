<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data_Jual extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = null;

    protected $fillable = [
        'nota_id',
        'no_nota',
        'code',
        'qty',
        'satuan',
        'disc',
        'harga_jual',
        'harga_beli'
    ];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }
}
