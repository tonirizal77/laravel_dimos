<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = ['tipe','konversi','nilai','kode','usaha_id'];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }
}
