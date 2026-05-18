<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiyComponentOption extends Model
{
    protected $fillable = [
        'diy_recipe_component_id',
        'product_id',
        'recommended_quantity',
        'is_default'
    ];

    public function component()
    {
        return $this->belongsTo(DiyRecipeComponent::class, 'diy_recipe_component_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}