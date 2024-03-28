<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'nisn',
        'name',
        'password',
        'gender'
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
