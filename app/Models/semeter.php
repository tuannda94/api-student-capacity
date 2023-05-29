<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semeter extends Model
{
    use HasFactory;
    protected $table='semester';

    public function semeter_subject()
    {
        return $this->belongsToMany(Question::class, 'semester_subject', 'id_semeter', 'id_subject');
    }
}
