<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    /**
     * Get all of the comments for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kota()
    {
        return $this->hasMany(Kota::class, 'province_id', 'id');
    }
}
