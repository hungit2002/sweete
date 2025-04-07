<?php

namespace App\Services\Image;

use App\Models\Image;

interface ImageServiceInterface
{
    public function getImageByUserID($userID, $perPage) : array;
}
