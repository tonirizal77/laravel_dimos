<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midtrans_Config extends Model
{
    use HasFactory;

    protected $table = 'midtrans_config';

    protected $fillable = [
        'usaha_id',
        'server_key',
        'client_key',
        'is_production',
        'is_sanitized',
        'is_3ds',
    ];

}
