<?php

namespace App\Usecases\Post;

interface PostUsecaseInterface
{
    public function createPost($userID, $content, $images, $friends, $feeling, $status, $background, $checkin);

    public function getListPost($params);
}
