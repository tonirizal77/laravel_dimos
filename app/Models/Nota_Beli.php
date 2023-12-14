<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota_Beli extends Model
{
    use HasFactory;
    // use SoftDeletes;

    // protected $table = "nota_beli";

    protected $fillable = [
        'no_nota',
        'tanggal',
        'supplier_id',
        'brutto',
        'disc',
        'total',
        'tunai',
        'kredit',
        'kartu',
        'tempo',
        'tgl_tempo',
        'user_id'
    ];
}
