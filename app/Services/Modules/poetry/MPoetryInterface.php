<?php

namespace App\Services\Modules\poetry;

interface MPoetryInterface
{
    public function ListPoetry();

    public function getItem($id);

}
