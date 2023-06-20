<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MBlock\Block;
class BlockController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private Block                          $block,

    )
    {
    }
    public function index($id_semeter){
        $data = $this->block->getWhereList($id_semeter);
        return response()->json(['data' => $data], 200);
    }

    public function block($id_semeter){
        $data = $this->block->getWhereList($id_semeter);
        return view('pages.blocks.index',['data' => $data,'id' => $id_semeter]);
    }
}
