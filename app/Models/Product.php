<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'specification',
        'price',
        'stock',
        'unit',
        'description',
        'image'
    ];

    public function componentOptions()
    {
        return $this->hasMany(DiyComponentOption::class);
    }
}