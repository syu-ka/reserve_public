<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_serial_num',
        'reservation_id',
        'status',
        'used_at',
    ];
    protected $casts = [
        'used_at' => 'datetime',
    ];

    /**
     * 生徒とのリレーション
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_serial_num', 'serial_num');
    }

    /**
     * 予約とのリレーション
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}