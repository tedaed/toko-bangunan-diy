<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiyRecipeComponent extends Model
{
    protected $fillable = [
        'diy_recipe_id',
        'component_name',
        'component_type',
        'is_required'
    ];

    public function recipe()
    {
        return $this->belongsTo(DiyRecipe::class, 'diy_recipe_id');
    }

    public function options()
    {
        return $this->hasMany(DiyComponentOption::class);
    }
}