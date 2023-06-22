<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use App\Services\Modules\MSemeter\Semeter;
use App\Models\block;
use App\Models\poetry;

class chartController extends Controller
{
    use TUploadImage, TCheckUserDrugTeam, TResponse;
    public function __construct(
        private Semeter           $interfaceSemeter,

    )
    {
    }
    public function index(){
        $listSemeter = $this->interfaceSemeter->GetSemeter();
        $blockTotal = block::all();
//        $blockTotal->load(['semeterOne' => function($q){
//            return $q->select('id','name');
//        }]);
        $dataChart = [];
        foreach ($blockTotal as $block) {
            $dataChart['nameBlock'][] = $block->semeterOne == null ? $block->name . '-' . 'không xác đinh' : $block->name . '-'. $block->semeterOne->name;
            $dataChart['total_poetry'][] = poetry::where('id_semeter', $block->id_semeter)->count();
        }

        return view('pages.chart.index',['semeters' => $listSemeter,'dataChart' => $dataChart]);
    }

    public function detail(){
        return view('pages.chart.chart');
    }
}
