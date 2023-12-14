<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usaha extends Model
{
    use HasFactory;

    protected $table = 'usaha';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipe_usaha',
        'logo',
        'nama',
        'email',
        'alamat',
        'telpon',
        'cities_id',
        'province_id',
        'status',
        'status_akun',
        'toko_online',
        'access_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_key',
        'status',
        'status_akun',
        'toko_online',
    ];

    public function kota()
    {
        return $this->hasOne(Kota::class, 'id','cities_id');
    }
    public function province()
    {
        return $this->hasOne(Province::class, 'id','province_id');
    }
}
