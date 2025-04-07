<?php

namespace App\Usecases\Post;

use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagsImage;
use App\Models\User;
use App\Repositories\Images\ImageRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\TagImage\TagImageRepositoryInterface;
use App\Repositories\Tags\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Usecases\BaseUsecase;
use Illuminate\Support\Facades\DB;

class PostUsecase extends BaseUsecase implements PostUsecaseInterface
{
    protected PostRepositoryInterface $postRepo;
    protected TagRepositoryInterface $tagsRepo;
    protected ImageRepositoryInterface $imageRepo;
    protected UserRepositoryInterface $userRepo;
    protected TagImageRepositoryInterface $tagImageRepo;

    public function __construct(
        PostRepositoryInterface     $postRepo,
        TagRepositoryInterface      $tagsRepo,
        ImageRepositoryInterface    $imageRepo,
        UserRepositoryInterface     $userRepo,
        TagImageRepositoryInterface $tagImageRepo,
    )
    {
        $this->postRepo = $postRepo;
        $this->tagsRepo = $tagsRepo;
        $this->imageRepo = $imageRepo;
        $this->userRepo = $userRepo;
        $this->tagImageRepo = $tagImageRepo;
    }

    public function createPost($userID, $content, $images, $friends, $feeling, $status, $background, $checkin, $gifs)
    {
        $user = $this->userRepo->find($userID);
        if (!$user) {
            goto next;
        }
        $newPost = [
            Post::_USER_ID => $userID,
            Post::_CONTENT => $content,
            Post::_BACKGROUND => $background,
            Post::_CHECKIN => $checkin,
            Post::_FEELING => $feeling,
            Post::_STATUS => $status['type'],
            Post::_CREATED_AT => date('Y-m-d H:i:s'),
            Post::_UPDATED_AT => date('Y-m-d H:i:s')
        ];
        DB::beginTransaction();
        try {
            $post = $this->postRepo->create($newPost);
            $tags = $this->prepareDataTagsInsert($post->id, $friends);
            $this->tagsRepo->insert($tags);

            $results = $this->createImages($post->id, $post->user_id, $images);
            $gifs = $this->imageRepo->insert($this->prepareDataInsertGifs($post->id, $gifs));
            if ($status['type'] === Post::STATUS_FRIEND_SPECIFIC) {
                $this->postRepo->update($post->id, [
                    Post::_FRIENDS_VIEW => json_encode(array_column($status['friends_specific'], 'id'))
                ]);
            } else if ($status['type'] === Post::STATUS_FRIEND_EXPECT) {
                $this->postRepo->update($post->id, [
                    Post::_FRIENDS_EXPECT => json_encode(array_column($status['friends_expect'], 'id'))
                ]);
            } else if ($status['type'] === Post::STATUS_CUSTOM) {
                $this->postRepo->update($post->id, [
                    Post::_FRIENDS_VIEW => json_encode(array_column($status['friends_specific'], 'id')),
                    Post::_FRIENDS_EXPECT => json_encode(array_column($status['friends_expect'], 'id'))
                ]);
            }
            DB::commit();
            return [true, "success", [
                "post" => $post,
                "images" => $results,
                "gifts" => $gifs
            ]];
        } catch (\Exception $e) {
            DB::rollBack();
            return [false, $e->getMessage(), null];
        }
        next:
        return [false, "", null];
    }

    private function prepareDataTagsInsert($postID, $friends)
    {
        $dataInsert = [];
        foreach ($friends as $friend) {
            $dataInsert[] = [
                Tag::_POST_ID => $postID,
                Tag::_USER_ID => $friend['id'],
                Tag::_CREATED_AT => date('Y-m-d H:i:s'),
                Tag::_UPDATED_AT => date('Y-m-d H:i:s')
            ];
        }
        return $dataInsert;
    }

    public function getListPost($params)
    {

        $params["with"] = [
            "tags" => function ($query) {
                $query->select([
                    User::TABLE . '.' . User::_ID,
                    User::TABLE . '.' . User::_FULLNAME,
                    User::TABLE . '.' . User::_AVATAR,
                ]);
            },
            "images" => function ($query) {
                $query->select([
                    Image::TABLE . '.' . Image::_ID,
                    Image::TABLE . '.' . Image::_PATH,
                    Image::TABLE . '.' . Image::_ORIGIN_NAME,
                    Image::TABLE . '.' . Image::_NOTE,
                    Image::TABLE . '.' . Image::_POST_ID,
                    Image::TABLE . '.' . Image::_TYPE,
                ]);
            },
            "images.tagImages" => function ($query) {
                $query->select([
                    User::TABLE . '.' . User::_ID,
                    User::TABLE . '.' . User::_FULLNAME,
                    User::TABLE . '.' . User::_AVATAR,
                ]);
            },
            "user" => function ($query) {
                $query->select([
                    User::TABLE . '.' . User::_ID,
                    User::TABLE . '.' . User::_FULLNAME,
                    User::TABLE . '.' . User::_AVATAR,
                ]);
            }
        ];
        $posts = $this->postRepo->getListByParams($params)->toArray();
        $friends = $this->getFriendInfos($posts);
        return [$posts, $friends];
    }

    private function createImages($postID, $userID, $images)
    {
        $results = [];
        foreach ($images as $image) {
            $newImage = [
                Image::_PATH => $image['url'],
                Image::_ORIGIN_NAME => $image['name'],
                Image::_SIZE => $image['size'],
                Image::_TYPE => $image['type'],
                Image::_NOTE => $image['note'],
                Image::_POST_ID => $postID,
                Image::_USER_ID => $userID,
                Image::_CREATED_AT => date('Y-m-d H:i:s'),
                Image::_UPDATED_AT => date('Y-m-d H:i:s'),
            ];
            $imageResult = $this->imageRepo->create($newImage);
            if ($image && $image['friends']) {
                $this->tagImageRepo->insert($this->prepareTagImageDataInsert($imageResult->id, $image['friends']));
            }
            $results[] = $imageResult['id'];
        }
        return $results;
    }

    private function prepareTagImageDataInsert($id, $friends)
    {
        $dataInsert = [];
        foreach ($friends as $friend) {
            $dataInsert[] = [
                TagsImage::_IMAGE_ID => $id,
                TagsImage::_USER_ID => $friend["id"],
                Tag::_CREATED_AT => date('Y-m-d H:i:s'),
                Tag::_UPDATED_AT => date('Y-m-d H:i:s')
            ];
        }
        return $dataInsert;
    }

    private function prepareDataInsertGifs($id, $gifs)
    {
        $dataInsert = [];
        foreach ($gifs as $gif) {
            $dataInsert[] = [
                Image::_PATH => $gif['url'],
                Image::_ORIGIN_NAME => $gif['name'],
                Image::_SIZE => $gif['size'],
                Image::_TYPE => $gif['type'],
                Image::_POST_ID => $id,
                Image::_CREATED_AT => date('Y-m-d H:i:s'),
                Image::_UPDATED_AT => date('Y-m-d H:i:s')
            ];
        }
        return $dataInsert;
    }

    /**
     * @param $data
     * @return array
     */
    public function extractedFriendIDsInStatusPost($data)
    {
        $friendViews = array_column($data, "friends_view");
        $friendExpect = array_column($data, "friends_expect");

        $friendViews = array_filter($friendViews, function ($value) {
            return is_array(json_decode($value, true));
        });
        $friendExpect = array_filter($friendExpect, function ($value) {
            return is_array(json_decode($value, true));
        });

        $friendIDs = array_merge($friendViews, $friendExpect);
        $friendIDs = array_merge(...array_map(fn($item) => json_decode($item, true), $friendIDs));
        return array_unique($friendIDs);
    }

    private function getFriendInfos($posts)
    {
        $friendIDsStatus = $this->extractedFriendIDsInStatusPost($posts['data']);
        $param = [
            'ids' => $friendIDsStatus,
        ];
        $select = [
            User::_ID,
            User::_FULLNAME,
        ];
        return $this->userRepo->getListByParams($param, $select)->keyBy(User::_ID)->toArray();
    }
}
