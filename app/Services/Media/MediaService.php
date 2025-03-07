<?php

namespace App\Services\Media;

use App\Services\BaseService;
use Illuminate\Support\Facades\Config;

class MediaService extends BaseService implements MediaServiceInterface
{

    public function uploadImages($images)
    {
        $url = Config::get("environment.MEDIA_DOMAIN") . "/api/upload";
    }
}
