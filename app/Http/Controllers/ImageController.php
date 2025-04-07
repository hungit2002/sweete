<?php

namespace App\Http\Controllers;

use App\Services\Image\ImageServiceInterface;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected Request $request;
    protected ImageServiceInterface $imageService;

    public function __construct(
        Request $request,
        ImageServiceInterface $imageService
    )
    {
        $this->request = $request;
        $this->imageService = $imageService;
    }

    public function getImageByUserID($userID): \Illuminate\Http\JsonResponse
    {
        $perPage = $this->request->get('per_page') ?? 8;

        list($checked, $mgs, $images) = $this->imageService->getImageByUserID($userID,$perPage);

        $this->status = $checked ? 200 : 400;
        $this->message = $mgs;

        return $this->responseData($images);
    }
}
