<?php

namespace App\Services\Modules\poetry;
use App\Models\poetry as modelPoetry;
class poetry implements MPoetryInterface
{
    public function __construct(
        private modelPoetry $modelPoetry
    )
    {
    }

    public function ListPoetry($id){
        try {
            return $this->modelPoetry->where('id_semeter',$id)->paginate(10);
        }catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryRespone($idSubject){
        try {
            $records = $this->modelPoetry->where('id_subject',$idSubject)->get();
            $records->load(['classsubject'  => function ($q) {
                return $q->select('id','name','code_class');
            }]);
            return $records;
        }catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryDetail($id_subject,$id_class){
        try {
            $records = $this->modelPoetry->where('id_subject',$id_subject)->where('id_class',$id_class)->get();
            $records->load(['classsubject'  => function ($q) {
                return $q->select('id','name','code_class');
            }]);
            $records->load(['subject'  => function ($q) {
                return $q->select('id','name');
            }]);
            $records->load(['subject'  => function ($q) {
                return $q->select('id','name');
            }]);
            $records->load(['examination'  => function ($q) {
                return $q->select('id','name');
            }]);
            $records->load(['semeter'  => function ($q) {
                return $q->select('id','name');
            }]);
            return $records;
        }catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryApi($id,$id_user){
        try {
            $records = $this->modelPoetry->where('id_semeter',$id)->get();
            $data['name_item'] =$records[0]->semeter->name;
            foreach ($records as $value){
                if ($value->playtopic === null) {
                    continue;
                }

                $data['data'][] = [
                    "id" => $value->id,
                    "id_subject" => $value->id_subject,
                    "name_semeter" => $value->semeter->name,
                    "name_subject" => $value->subject->name,
                    "name_class" => $value->classsubject->name,
                    "name_examtion" => $value->examination->name,
                    "start_time" => $value->start_time,
                    "end_time" => $value->end_time,
                ];
            }
            return $data;
        }catch (\Exception $e) {
            return false;
        }
    }
    public function onePoetryApi($id_poetry){
        try {
            $records = $this->modelPoetry::select('start_time', 'end_time')->find($id_poetry);
            return $records;
        }catch (\Exception $e) {
            return false;
        }
    }
    public function getItem($id){
        try {
            $poetry = $this->modelPoetry::find($id);
            $data = ['name_semeter' => $poetry->semeter->name,'name_subject' =>  $poetry->subject->name,'nameClass' => $poetry->classsubject->name,'nameExamtion' =>  $poetry->examination->name,'start_time1' => $poetry->start_time,'end_time2' => $poetry->end_time ];
            return $data;
        }catch (\Exception $e) {
            return false;
        }
    }

    public function getItempoetry($id)
    {
        {
            try {
                return $this->modelPoetry->find($id);
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
