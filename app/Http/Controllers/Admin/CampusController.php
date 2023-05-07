<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    use TStatus, TResponse;

    private $campus;
    private $modulesCampus;

    public function __construct(Campus $campus, \App\Services\Modules\MCampus\Campus  $modulesCampus)
    {
        $this->campus = $campus;
        $this->modulesCampus = $modulesCampus;
    }

    public function apiIndex()
    {
        try {
            $data = $this->modulesCampus->apiIndex();
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }
}
