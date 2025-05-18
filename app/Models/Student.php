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
        'id', // ログインID（文字列）
        'name',
        'password',
        'fixed_lesson_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'student_serial_num');
    }

    public function fixedLesson()
    {
        return $this->belongsTo(FixedLesson::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'student_serial_num');
    }
}

