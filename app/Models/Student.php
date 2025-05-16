<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guard = 'student';

    protected $fillable = [
        'id',
        'name',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;// 自動増分ではない
    protected $keyType = 'string';// 主キーの型が文字列
}
