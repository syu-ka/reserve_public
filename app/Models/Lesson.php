<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date', 'weekday', 'start_time', 'required_time', 'capacity','fixed_lesson_id',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
