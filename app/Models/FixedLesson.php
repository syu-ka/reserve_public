<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'weekday',
        'start_time',
        'required_time',
        'capacity',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
