<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{
    use HasFactory;

    protected $table = 'frequently_asked_questions';

    protected $fillable = [
        'question',
        'answer',
        'type'
    ];

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
    ];
}
