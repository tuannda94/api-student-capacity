<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $table = "subject";
    public function semester_subject()
    {
        return $this->belongsToMany(semeter::class, 'semester_subject', 'id_subject', 'id_semeter');
    }


}
