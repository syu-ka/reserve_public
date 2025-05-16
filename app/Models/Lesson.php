<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date', 'start_time', 'end_time'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
