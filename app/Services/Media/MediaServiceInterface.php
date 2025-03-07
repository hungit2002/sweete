<?php
namespace App\Services\Media;
use App\Services\BaseServiceInterface;
interface MediaServiceInterface extends BaseServiceInterface
{
    public function uploadImages($images);
}
