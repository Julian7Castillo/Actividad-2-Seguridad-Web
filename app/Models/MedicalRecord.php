<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    use HasFactory;

     protected $fillable = [
        'medical_public_id',
        'allergies',
        'blood_type',
        'injuries',
        // agrega aquí todos los campos que aceptas
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
    
}
