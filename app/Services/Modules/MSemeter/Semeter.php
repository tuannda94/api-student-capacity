<?php

namespace App\Services\Modules\MSemeter;
use App\Models\semeter as SemeterModel;
class Semeter implements MSemeterInterface
{

    public function __construct(private SemeterModel $modelSemeter){

    }
    public function GetSemeter()
    {
        $data = $this->modelSemeter::all();
        return $data;
    }
}
