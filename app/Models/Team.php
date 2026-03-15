<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Team extends Model
{
    use HasFactory;

    /*
    * Get games for the team
    */
   public function games(): HasMany
   {
       return $this->hasMany(Game::class);
   }

    /**
     * Get the most recent game added
     */
    public function latestGame(): HasOne
    {
        return $this->hasOne(Game::class)->latestOfMany();
    }

    /**
     * Get the max anotation game
     */
    public function bestGame(): HasOne
    {
        return $this->games()->one()->ofMany('pts_team', 'max');
    }

    /**
     * The teams that belong to the player.
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class,'team_player');
    }

    /**
     * Get the team's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

}
