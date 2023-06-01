<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentPoetry extends Model
{
    use HasFactory;
    protected $table = 'student_poetry';
    public function userStudent()
    {
        return $this->belongsTo(User::class, 'id_student', 'id');
    }

    public function poetry()
    {
        return $this->belongsTo(poetry::class, 'id_poetry', 'id');
    }
}
