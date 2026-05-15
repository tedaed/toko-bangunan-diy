<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'unit',
        'description',
        'image'
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}