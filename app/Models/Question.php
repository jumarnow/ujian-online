<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question',
        'question_img',
        'option_1',
        'option_1_img',
        'option_2',
        'option_2_img',
        'option_3',
        'option_3_img',
        'option_4',
        'option_4_img',
        'answer',
        'tipe',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
