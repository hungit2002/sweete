<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\Feel\FeelRepositoryInterface;
use App\Usecases\Post\PostUsecaseInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected Request $request;
    protected PostUsecaseInterface $postUsecase;
    protected FeelRepositoryInterface $feelRepo;
    public function __construct(
        Request $request,
        PostUsecaseInterface $postUsecase,
        FeelRepositoryInterface $feelRepo
    )
    {
        $this->request = $request;
        $this->postUsecase = $postUsecase;
        $this->feelRepo = $feelRepo;
    }

    public function createPost()
    {
        $validated = $this->validateBase($this->request, [
            'user_id'    => 'integer|required',
            'content'    => 'required',
            'images'     => 'array',
            'friends'    => 'array',
            'feeling'    => 'int',
            'status'     => 'required',
            'background' => 'string',
            'checkin'    => 'string',
        ]);
        if ($validated) {
            $this->message = "validation fail";
            $this->code    = 422;
            return $this->responseData($validated);
        }
        $data = [];
        $userID        = $this->request->get('user_id');
        $content       = $this->request->get('content');
        $images        = $this->request->get('images');
        $friends       = $this->request->get('friends');
        $feeling       = $this->request->get('feeling');
        $status        = $this->request->get('status');
        $background    = $this->request->get('background');
        $checkin       = $this->request->get('checkin');
        $gifs          = $this->request->get('gifs');

        $feel = $this->feelRepo->find($feeling);
        if (!$feel){
            $this->message = "feel not found";
            $this->code = 400;
            goto next;
        }

        // check feels
        if (!in_array($status['type'], Post::LIST_STATUS)) {
            $this->message = "status incorrect";
            $this->code    = 422;
            goto next;
        }
        list($checked,$message,$data) = $this->postUsecase->createPost($userID, $content, $images, $friends, $feeling, $status, $background, $checkin, $gifs);
        if (!$checked){
            $this->message = $message;
            $this->code    = 400;
            goto next;
        }
        $this->status  = "success";
        $this->message = "create post success";
        $this->code    = 200;
        next:
        return $this->responseData($data);
    }

    public function getListPost()
    {
        $validated = $this->validateBase($this->request, [
            'user_id' => 'integer|required'
        ]);
        if ($validated) {
            $this->message = "validation fail";
            $this->code    = 422;
            return $this->responseData($validated);
        }
        $userID  = $this->request->get('user_id');
        $perPage = $this->request->get('per_page') ?? 20;

        $params['user_id'] = $userID;
        $params['per_page'] = $perPage;
        $posts              = $this->postUsecase->getListPost($params);

        $this->message = 'get list post success';
        $this->status  = 'success';
        return $this->responseData($posts);
    }
}
