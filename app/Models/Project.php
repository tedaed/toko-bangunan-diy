<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image'
    ];

    public function products()
    {
       return $this->belongsToMany(Product::class, 'project_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}