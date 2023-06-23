<?php

namespace App\Services\Modules\poetry;

use App\Models\blockSubject;
use App\Models\ClassModel;
use App\Models\examination;
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
                    'block_subject'
                ])
                ->where('id_semeter', $id)
                ->withWhereHas('block_subject', function ($q) use ($idblock) {
                    $q->where('id_block', $idblock);
                });
            if (!auth()->user()->hasRole('super admin')) {
                $records->where('id_campus', auth()->user()->campus->id);
            }
            if (auth()->user()->hasRole('teacher')) {
                $records->where('assigned_user_id', auth()->user()->id);
            }
//        foreach ($records->paginate(10) as $item) {
//            dd($item->block_subject);
//        }
//        dd($records->paginate(10));
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
                    $query->whereHas('block_subject', function ($subQuery) use ($idBlock) {
                        $subQuery->where('id_block',$idBlock);
                    });
                })
                ->when(!empty($id_subject) && empty($id_class), function ($query) use ($id_subject) {
                    $query->where('id_subject', $id_subject);
                })
                ->when(!empty($id_subject) && !empty($id_class), function ($query) use ($id_subject, $id_class) {
                    $query->where('id_subject', $id_subject)
                        ->where('id_class', $id_class);
                })->pluck('id');
            $studentRecords = studentPoetry::whereIn('id_poetry', $records)
                ->pluck('id_student')->unique()
                ->values();
            $student = User::whereIn('id', $studentRecords)->with('campus')->get();

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

    public function ListPoetryDetailChart($idSemeter, $idBlock, $id_subjects)
    {
        try {
            $records = $this->modelPoetry->when(!empty($idBlock), function ($query) use ($idBlock) {
                $query->whereHas('block_subject', function ($subQuery) use ($idBlock) {
                    $subQuery->where('id_block', $idBlock);
                });
            })
                ->where('id_semeter', $idSemeter) // Thêm điều kiện 'id_semester' = $idSemester
                ->where('id_subject', $id_subjects) // Thêm điều kiện 'id_subject' = $id_subject
                ->get();
            $data = [];
            foreach ($records as $value) {
                $data[] = [
                    'name' => $value->examination->name . '-' . $value->subject->name . "-" . $value->classsubject->name,
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
                ->select([
                    'poetry.id',
                    'poetry.id_block_subject',
                    'poetry.start_examination_id',
                    'poetry.finish_examination_id',
                    'poetry.room',
                    'poetry.assigned_user_id',
                    'poetry.id_campus',
                    'poetry.exam_date',
                    'semester.name as name_semeter',
                    'class.name as name_class',
                    'playtopic.exam_time',
                    'playtopic.exam_name',
                    'result_capacity.created_at',
                    'result_capacity.status',
                ])
                ->join('semester', 'semester.id', '=', 'poetry.id_semeter')
                ->join('class', 'class.id', '=', 'poetry.id_class')
                ->join('student_poetry', 'student_poetry.id_poetry', '=', 'poetry.id')
                ->join('playtopic', 'playtopic.student_poetry_id', '=', 'student_poetry.id')
                ->leftJoin('result_capacity', 'result_capacity.playtopic_id', '=', 'playtopic.id')
                ->where([
                    ['poetry.id_semeter', $id],
                    ['student_poetry.id_student', $id_user],
                    ['playtopic.has_received_exam', 1],
                    ['poetry.status', 1],
                    ['exam_date', date('Y-m-d')],
                ])
                ->orderBy('playtopic.created_at', 'DESC')
                ->orderBy('poetry.start_examination_id', 'DESC')
                ->get();
            $blockSubjectIds = $records->pluck('id_block_subject');
            $blockSubjectIdToSubjectName = blockSubject::query()
                ->select('subject.name', 'block_subject.id')
                ->join('subject', 'subject.id', 'block_subject.id_subject')
                ->whereIn('block_subject.id', $blockSubjectIds)->get()->pluck('name', 'id');
            $poetryIdToPoetryTime = examination::query()
                ->select('id', 'started_at', 'finished_at')
                ->get()->mapWithKeys(function ($item) {
                    return [$item['id'] => ['started_at' => $item['started_at'], 'finished_at' => $item['finished_at']]];
                })->toArray();
            $data = [];
            $data['name_item'] = $records[0]->name_semeter;
            foreach ($records as $value) {
//                if ($value->playtopic === null) {
//                    continue;
//                }
                $start_time = $value->exam_date . " " . $poetryIdToPoetryTime[$value->start_examination_id]['started_at'];
                $finish_time = $value->exam_date . " " . $poetryIdToPoetryTime[$value->finish_examination_id]['finished_at'];
                $is_in_time = !(time() < strtotime($start_time) || time() >= strtotime($finish_time));
                $have_done = (!empty($value->created_at) && $value->status == 1);
                $data['data'][] = [
                    "id" => $value->id,
                    "name_semeter" => $value->name_semeter,
                    'id_block_subject' => $value->id_block_subject,
                    "name_subject" => $blockSubjectIdToSubjectName[$value['id_block_subject']],
                    "name_class" => $value->name_class,
                    "room_name" => $value->room,
                    "exam_time" => $value->exam_time,
                    "exam_type" => 0,
                    'is_in_time' => $is_in_time,
                    'have_done' => $have_done,
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
                return $this->modelPoetry->with('user')->find($id);
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}
