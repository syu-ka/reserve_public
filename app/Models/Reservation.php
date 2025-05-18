<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_serial_num', 'lesson_id', 'status', 'ticket_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_serial_num');
        
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
