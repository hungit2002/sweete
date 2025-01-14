<?php

namespace App\Repositories\Images;

use App\Models\Image;
use App\Repositories\BaseRepository;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    public function getModel()
    {
        return Image::class;
    }
}
