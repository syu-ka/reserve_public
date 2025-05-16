<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'serial_num'; // 必要なら指定
    public $incrementing = true;

    protected $fillable = [
        'id', 'name', 'password'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'student_serial_num');
    }

    public function fixedSchedules()
    {
        return $this->hasMany(FixedSchedule::class, 'student_serial_num');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'student_serial_num');
    }
}

