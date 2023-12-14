<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = "pakets";

    protected $fillable = [
        'name',
        'gambar',
        'duration',
        'disc',
        'biaya',
        'uraian',
        'warna_header',
        'warna_body',
        'lama_disc',
    ];
}
