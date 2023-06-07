<?php

namespace App\Models;

use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionImage extends Model
{
    use HasFactory;

    protected $table = 'question_images';
    protected $casts = [
        'path' => FormatImageGet::class,
    ];
}
