<?php

namespace App\Services\User;

interface IUserServiceInterface
{
    public function insertUser();
    public function updatePoster($userID, $url, $size, $type, $name);
}
