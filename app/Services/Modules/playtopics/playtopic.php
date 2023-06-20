<?php

namespace App\Services\Modules\playtopics;

use App\Models\playtopic as modelPlayTopics;
class playtopic
{

    public function __construct(
        private modelPlayTopics $modelPlayTopic
    )
    {
    }

    public function getList($id_poetry){
        try {
            return $this->modelPlayTopic->where('id_poetry','=',$id_poetry)->paginate(10);
        }catch(\Exception $e){
            return $e;
        }
    }

    public function getExamApi($id_user,$id_poetry,$id_campus,$id_subject){
        try {
            $records = $this->modelPlayTopic
                ->query()
                ->select([
                    'playtopic.id',
                    'playtopic.exam_name as name',
                    'playtopic.questions_order as questions',
                    'subject.name as name_subject',
                ])
                ->leftJoin('student_poetry', 'student_poetry.id', '=', 'playtopic.student_poetry_id')
                ->leftJoin('poetry', 'poetry.id', '=', 'student_poetry.id_poetry')
                ->leftJoin('subject', 'subject.id', '=', 'poetry.id_subject')
                ->where('student_poetry.id_student','=',$id_user)
                ->where('student_poetry.id_poetry','=',$id_poetry)
                ->where('poetry.id_subject','=',$id_subject)->first();
//            $records['name_campus'] = $records->campusName;
//            foreach ($records as $value){
//                $data[] = [
//                    ""
//                ]
//            }
            return $records;
        }catch(\Exception $e){
            return $e;
        }
    }
}
