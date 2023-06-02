<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\playtopics\playtopic;
class playtopicController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private playtopic $playtopicModel
    )
    {
    }

    public function index($id){
        $playtopic = $this->playtopicModel->getList($id);
        dd($playtopic);
        return view('pages.poetry.playtopic.index',['playtopics' => $playtopic]);
    }

    public function List($id){

    }
}
