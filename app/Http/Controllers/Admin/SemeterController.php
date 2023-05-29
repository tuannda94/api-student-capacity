<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MSemeter\Semeter;

class SemeterController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private Semeter $semeter
    )
    {
    }

    public function index(){
        $data = $this->semeter->GetSemeter();
        dd($data);
    }
}
