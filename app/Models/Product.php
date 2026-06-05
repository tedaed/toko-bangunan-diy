<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'material_type',
        'specification',
        'length_cm',
        'width_cm',
        'thickness_cm',
        'diameter_mm',
        'size_inch',
        'price',
        'stock',
        'unit',
        'description',
        'image',
    ];

    public function componentOptions()
    {
        return $this->hasMany(DiyComponentOption::class);
    }
}
