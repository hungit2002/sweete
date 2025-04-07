<?php

namespace App\Services\Image;

use App\Repositories\Images\ImageRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class ImageService implements ImageServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected ImageRepositoryInterface $imageRepository;

    public function __construct(
        UserRepositoryInterface  $userRepository,
        ImageRepositoryInterface $imageRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getImageByUserID($userID, $perPage): array
    {
        $user = $this->userRepository->getById($userID);
        if (!isset($user)) {
            return [false, "User not found", []];
        }
        $images = $this->imageRepository->getImagesByUserID($userID, $perPage);
        return [true,"get image success", $images];
    }
}
