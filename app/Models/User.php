<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'alamat',
        'cities_id',
        'telpon',
        'profilePicture',
        'active',
        'relations_id',
        'name_relations',
        'access_key',
        'usaha_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'access_key',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the kota associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kota()
    {
        return $this->hasOne(Kota::class, 'id', 'cities_id');
    }
    public function provinsi()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function usaha()
    {
        return $this->hasOne(Usaha::class, 'id', 'usaha_id');
    }

}
