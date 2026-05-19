<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    protected $fillable = [
        'project_id',
        'customer_name',
        'phone',
        'length',
        'width',
        'height',
        'quality',
        'note',
        'status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}