<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'name',
        'room_type',
        'floor',
        'capacity',
        'price_per_day',
        'status',
        'description'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'price_per_day' => 'decimal:2',
    ];

    /**
     * Get the inpatients for the room
     */
    public function inpatients(): HasMany
    {
        return $this->hasMany(Inpatient::class);
    }
}
