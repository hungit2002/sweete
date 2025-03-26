<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{

    public function getModel()
    {
        return Post::class;
    }

    public function getListByParams($params, $select = ["*"])
    {
        $query = $this->_model->select();
        $query = $this->queryWith($query, $params);
        $query = $this->queryByParams($query, $params);

        if (isset($params['per_page'])) {
            return $query->paginate($params['per_page']);
        }
        return $query->orderBy(Post::_CREATED_AT, 'desc')->get();
    }

    private function queryWith($query, $params)
    {
        if (isset($params['with'])) {
            $query->with($params['with']);
        }
        return $query;
    }

    private function queryByParams($query, $params)
    {
        $query = $query->whereNull(Post::_DELETED_AT);
        if (isset($params['user_id'])) {
            $query = $query->where(Post::_USER_ID, $params['user_id']);
        }
        return $query;
    }
}
