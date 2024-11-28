<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class FormatImageGet implements CastsAttributes
{
    private $arrayCheckNameRoute = [
        "admin.round.detail.team.make.exam",
        "admin.exam.index"
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        if ($this->__checkRoute()) return $value;
        //check file exist in S3 bucket
        $s3 = new S3Client([
            'region' => env('AWS_DEFAULT_REGION')
        ]);
        $bucket = env('AWS_BUCKET');
        // if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addDays(7));
        
        if (!isset($value) || !$s3->doesObjectExistV2($bucket, $value)) {
            return Storage::disk('s3')->temporaryUrl('abc.jpg', now()->addDays(7));
        } else {
            return Storage::disk('s3')->temporaryUrl($value, now()->addDays(7));
        }
        return ($model->getTable() == 'users') ? $value : $value;
    }

    private function __checkRoute()
    {
        if (request()->route()) {
            $routeName = (request()->route()->getName() ?? "ABS");
            if (in_array($routeName, $this->arrayCheckNameRoute)) return true;
        };
        return false;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
