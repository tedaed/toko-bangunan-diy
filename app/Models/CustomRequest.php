<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomRequest extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'project_id',
        'quality',
        'length',
        'width',
        'height',
        'note',
        'status',
        'status_note',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
