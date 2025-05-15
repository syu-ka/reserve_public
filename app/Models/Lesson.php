<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'start_time',
        'end_time',
        'capacity',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(LessonReservation::class);
    }
}
