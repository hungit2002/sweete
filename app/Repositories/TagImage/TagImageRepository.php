<?php

namespace App\Repositories\TagImage;

use App\Models\TagsImage;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryInterface;
class TagImageRepository extends BaseRepository implements TagImageRepositoryInterface
{

    public function getModel()
    {
        return TagsImage::class;
    }
}
