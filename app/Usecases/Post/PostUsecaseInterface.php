<?php

namespace App\Usecases\Post;

interface PostUsecaseInterface
{
    public function createPost($userID, $content, $images, $friends, $feeling, $status, $background, $checkin, $gifs);

    public function getListPost($params);
}
