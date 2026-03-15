<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use DateTimeInterface;
class Player extends Model
{
    use HasFactory;

    public function medical_record(): HasOne
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The teams that belong to the player.
     */
    public function teams():BelongsToMany

    {
        return $this->belongsToMany(Team::class,'team_player');
    }

    /**
     * Get the player's image.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d');
    }

    protected function casts(): array
    {
            return [
                'date_birth' => 'date:d-m-Y',
            ];
    }
}
