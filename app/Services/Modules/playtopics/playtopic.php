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
            return $this->modelPlayTopic->where('id_poetry','=',$id_poetry)->get();
        }catch(\Exception $e){
            return $e;
        }
    }
}
