<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hutang extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $table = "hutangs";

    protected $fillable = [
        'supplier_id',
        'nota_id',
        'no_nota',
        'tanggal',
        'jumlah',
        'status',
        'user_id'
    ];
}
