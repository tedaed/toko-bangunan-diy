<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiyRecipe extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'length',
        'width',
        'height',
        'description',
        'image'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function components()
    {
        return $this->hasMany(DiyRecipeComponent::class);
    }
}