<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kota extends Model
{
    use HasFactory;

    protected $table = 'cities';

    /**
     * Get the user that owns the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'cities_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }


}
