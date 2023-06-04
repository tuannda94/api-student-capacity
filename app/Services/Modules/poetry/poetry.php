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

    public function ListPoetry(){
        try {
            return $this->modelPoetry->paginate(10);
        }catch (\Exception $e) {
            return false;
        }
    }

    public function getItem($id){
        try {
            $poetry = $this->modelPoetry::find($id);
            $data = ['name_semeter' => $poetry->semeter->name,'name_subject' =>  $poetry->subject->name];
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
