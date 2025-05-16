<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_serial_num', 'weekday', 'start_time', 'end_time', 'title'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_serial_num');
    }
}