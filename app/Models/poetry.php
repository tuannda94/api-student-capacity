<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poetry extends Model
{
    use HasFactory;
    protected $table = 'poetry';
    protected $fillable = ['id_semeter','id_subject','id_class','id_examination','status','start_time','end_time','created_at','updated_at'];
    public function semeter(){
        return $this->hasOne(semeter::class,'id','id_semeter');
    }

    public function subject(){
        return $this->hasOne(subject::class,'id','id_subject');
    }
    public function classsubject(){
        return $this->hasOne(ClassModel::class,'id','id_class');
    }

    public function playtopic(){
        return $this->hasOne(playtopic::class,'id_poetry','id');
    }

    public function examination(){
        return $this->hasOne(examination::class,'id','id_examination');
    }

    public function campus(){
        return $this->hasOne(Campus::class,'id','id_campus');
    }

}
