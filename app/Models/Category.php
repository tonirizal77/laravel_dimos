<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = ['name','icons','active','usaha_id'];

    public function scopeTable($query, $tableName)
    {
        return $query->from($tableName);
    }
}
