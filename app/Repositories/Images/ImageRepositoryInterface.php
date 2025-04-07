<?php

namespace App\Repositories\Images;
use App\Repositories\RepositoryInterface;
interface ImageRepositoryInterface extends RepositoryInterface
{
    public function getImagesByUserID($userID, $perPage);
}
