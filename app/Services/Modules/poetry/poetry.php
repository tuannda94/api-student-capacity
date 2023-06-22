<?php

namespace App\Services\Modules\poetry;

use App\Models\ClassModel;
use App\Models\poetry as modelPoetry;
use App\Models\semeter;
use App\Models\studentPoetry;
use App\Models\subject;
use App\Models\User;
class poetry implements MPoetryInterface
{
    public function __construct(
        private modelPoetry $modelPoetry
    )
    {
    }

    public function ListPoetry($id, $idblock)
    {
        try {
            $records = $this->modelPoetry
                ->with([
                    'semeter',
                    'classsubject',
                    'user',
                    'campus',
                ])
                ->where('id_semeter', $id)
                ->withWhereHas('block_subject', function ($q) use ($idblock) {
                    $q->where('id_block', $idblock);
                });
            if (!auth()->user()->hasRole('super admin')) {
                $records->where('id_campus', auth()->user()->campus->id);
            }
            return $records->paginate(10);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryRespone($idSubject)
    {
        try {
            $records = $this->modelPoetry->where('id_subject', $idSubject)->get();
            $records->load(['classsubject' => function ($q) {
                return $q->select('id', 'name', 'code_class');
            }]);
            return $records;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function ListPoetryDetail($idSemeter, $idBlock, $id_subject, $id_class)
    {
        try {
            $records = $this->modelPoetry->when(!empty($idSemeter), function ($query) use ($idSemeter) {
                $query->where('id_semeter', $idSemeter);
            })
                ->when(!empty($idBlock), function ($query) use ($idBlock) {
                    $query->whereHas('subject', function ($subQuery) use ($idBlock) {
                        $subQuery->where('id_block', $idBlock);
                    });
                })
                ->when(!empty($id_subject) && empty($id_class), function ($query) use ($id_subject) {
                    $query->where('id_subject', $id_subject);
                })
                ->when(!empty($id_subject) && !empty($id_class), function ($query) use ($id_subject, $id_class) {
                    $query->where('id_subject', $id_subject)
                        ->where('id_class', $id_class);
                })
                ->pluck('id');
            $studentRecords = studentPoetry::whereIn('id_poetry', $records)
                ->pluck('id_student')->unique()
                ->values();
            $student = User::whereIn('id',$studentRecords)->with('campus')->get();

//            $records->load(['classsubject'  => function ($q) {
//                return $q->select('id','name','code_class');
//            }]);
//            $records->load(['std_poetry'  => function ($q) {
//                return $q->select('id_student');
//            }]);
//
//            $records->load(['subject.block' => function ($q) {
//                return $q->select('id','name');
//            }]);
//
//            $records->load(['semeter' => function ($q) {
//                return $q->select('id', 'name');
//            }]);
            return $student;
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function ListPoetryDetailChart($idSemeter,$idBlock,$id_subjects){
        try {
            $records = $this->modelPoetry->when(!empty($idBlock), function ($query) use ($idBlock) {
                $query->whereHas('subject', function ($subQuery) use ($idBlock) {
                    $subQuery->where('id_block', $idBlock);
                });
            })
                ->where('id_semeter', $idSemeter) // Thêm điều kiện 'id_semester' = $idSemester
                ->where('id_subject', $id_subjects) // Thêm điều kiện 'id_subject' = $id_subject
                ->get();
            $data  = [];
            foreach ($records as $value){
                $data[]=[
                    'name' =>  $value->examination->name . '-'. $value->subject->name ."-". $value->classsubject->name,
                    'id_poetry' => $value->id
                ];
            }

            return $data;
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function ListPoetryApi($id, $id_user)
    {
        try {
            $records = $this->modelPoetry
                ->query()
                ->select(
                    'poetry.id',
                    'poetry.id_subject',
                    'poetry.start_time',
                    'poetry.end_time',
                    'poetry.end_time',
                    'semester.name as name_semeter',
                    'subject.name as name_subject',
                    'class.name as name_class',
                    'examination.name as name_examination'
                )
                ->join('semester', 'semester.id', '=', 'poetry.id_semeter')
                ->join('subject', 'subject.id', '=', 'poetry.id_subject')
                ->join('class', 'class.id', '=', 'poetry.id_class')
                ->join('examination', 'examination.id', '=', 'poetry.id_examination')
                ->join('student_poetry', 'student_poetry.id_poetry', '=', 'poetry.id')
                ->join('playtopic', 'playtopic.student_poetry_id', '=', 'student_poetry.id')
                ->where('poetry.id_semeter', $id)
                ->where('student_poetry.id_student', $id_user)
                ->where('playtopic.has_received_exam', 1)
                ->get();
            $data['name_item'] = $records[0]->name_semeter;
            foreach ($records as $value) {
//                if ($value->playtopic === null) {
//                    continue;
//                }

                $data['data'][] = [
                    "id" => $value->id,
                    "id_subject" => $value->id_subject,
                    "name_semeter" => $value->name_semeter,
                    "name_subject" => $value->name_subject,
                    "name_class" => $value->name_class,
                    "name_examtion" => $value->name_examination,
                    "start_time" => $value->start_time,
                    "end_time" => $value->end_time,
                ];
            }
            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function onePoetryApi($id_poetry)
    {
        try {
            $records = $this->modelPoetry::select('start_time', 'end_time')->find($id_poetry);
            return $records;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItem($id)
    {
        try {
            $poetry = $this->modelPoetry::find($id);
            $data = ['name_semeter' => $poetry->semeter->name, 'name_subject' => $poetry->subject->name, 'nameClass' => $poetry->classsubject->name, 'nameExamtion' => $poetry->examination->name, 'name_campus' => $poetry->campus->name];
            return $data;
        } catch (\Exception $e) {
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
