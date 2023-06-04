<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poetry extends Model
{
    use HasFactory;
    protected $table = 'poetry';

    public function semeter(){
        return $this->hasOne(semeter::class,'id','id_semeter');
    }

    public function subject(){
        return $this->hasOne(subject::class,'id','id_subject');
    }
}
