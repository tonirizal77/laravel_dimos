<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = null;

    protected $fillable = [
        'code','description','name','gambar',
        'harga_beli','harga_jual','stock_aw', 'stock_ak',
        'kategory_id','sat_beli','sat_jual','sat_konversi',
        'usaha_id', 'nil_konversi','harga_modal','deleted_at'
    ];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }

    public function kategori()
    {
        return $this->hasOne(Category::class, 'id', 'kategory_id');
    }

}
