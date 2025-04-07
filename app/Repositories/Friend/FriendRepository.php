<?php

namespace App\Repositories\Friend;

use App\Models\Friend;
use App\Repositories\BaseRepository;

class FriendRepository extends BaseRepository implements FriendRepositoryInterface
{

    public function getModel()
    {
        // TODO: Implement getModel() method.
        return Friend::class;
    }
}
