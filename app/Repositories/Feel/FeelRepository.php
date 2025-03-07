<?php

namespace App\Repositories\Feel;

use App\Models\Feel;
use App\Repositories\BaseRepository;

class FeelRepository extends BaseRepository implements FeelRepositoryInterface
{

    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Feel::class;
    }
}
