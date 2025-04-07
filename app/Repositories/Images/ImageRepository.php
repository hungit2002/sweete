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

    public function getImagesByUserID($userID, $perPage)
    {
        return $this->_model->where(Image::_USER_ID,$userID)->whereNull(Image::_DELETED_AT)->paginate($perPage);
    }
}
