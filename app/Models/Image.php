<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Image extends Model
{
    use HasFactory;
    //protected $hidden = ['imageable_type','imageable_id'];
    protected $visible = ['id', 'url'];
    
    // 
    /**
     * Get the parent imageable model (player or team).
     */
    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
