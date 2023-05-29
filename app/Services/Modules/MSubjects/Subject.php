<?php

namespace App\Services\Modules\MSubjects;

use App\Models\subject as SubjectModel;

class Subject
{
    public function __construct(private SubjectModel $mSubject)
    {
    }

    public function getListSb()
    {
        return $this->mSubject;
    }

    public function ListSubject()
    {
        try {
            return $this->getListSb()
                ->paginate(5);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getItemSubject($id)
    {
        {
            try {
                return $this->mSubject->find($id);
            } catch (\Exception $e) {
                return false;
            }
        }
    }
}