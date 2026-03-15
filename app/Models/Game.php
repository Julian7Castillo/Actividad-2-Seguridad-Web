<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

     protected $fillable = [
        'is_home',
        'pts_team',
        'pts_op_team',
        'date_play',
        'name_op_team',
        'team_id'
    ];

    /**
     * Get team for the game
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
