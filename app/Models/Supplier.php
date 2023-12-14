<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = null;

    protected $fillable = ['nama','alamat','telpon','prov_id','kota_id','status'];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }

    public function kota()
    {
        return $this->hasOne(Kota::class, 'id','kota_id');
    }

    public function provinsi()
    {
        return $this->hasOne(Province::class, 'id','prov_id');
    }
}
