<?php

namespace App\Services\Modules\MSemeter;
use App\Models\semeter as SemeterModel;
class Semeter implements MSemeterInterface
{

    public function __construct(private SemeterModel $modelSemeter){

    }
    public function ListSemeter(){
        return $this->modelSemeter::all();
    }
    public function GetSemeter()
    {
        $data = $this->modelSemeter::paginate(5);
        return $data;
    }

    public function getItemSemeter($id){
        try {
            return $this->modelSemeter->find($id);
        } catch (\Exception $e) {
            return false;
        }
    }
}
