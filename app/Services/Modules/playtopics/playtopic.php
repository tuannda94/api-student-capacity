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
            $records = $this->modelPlayTopic->where('id_user','=',$id_user)
                ->where('id_poetry','=',$id_poetry)
                ->where('id_campus','=',$id_campus)
                ->where('id_subject','=',$id_subject)->first();
            $data = [];
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
