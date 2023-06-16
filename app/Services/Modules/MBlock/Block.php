<?php

namespace App\Services\Modules\MBlock;
use App\Models\block as model;
class Block
{
    private $block;
    public function __construct(model $model)
    {
        $this->block = $model;
    }

    public function getWhereList($id){
        return $this->block->where('id_semeter',$id)->get();
    }

}
