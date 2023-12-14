<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data_Beli extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $table = "data_beli";

    protected $fillable = [
        'nota_id',
        'no_nota',
        'code',
        'qty',
        'satuan',
        'harga_beli'
    ];
}
