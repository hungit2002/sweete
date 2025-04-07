<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    protected Request $request;
    protected FriendRepositoryInterface $friendRepository;

    public function __construct(
        Request                   $request,
        FriendRepositoryInterface $friendRepository,
        UserRepositoryInterface   $userRepository
    )
    {
        $this->request = $request;
        $this->friendRepository = $friendRepository;
        $this->userRepository = $userRepository;
    }

    public function getFriendByParam()
    {
        $validated = $this->validateBase($this->request, [
            'user_id' => 'required',
        ]);
        if ($validated) {
            $this->message = "validation fail";
            $this->code = 422;
            return $this->responseData($validated);
        }
        $userID = $this->request->get('user_id');
        $fullName = $this->request->get('full_name');
        $limit = $this->request->get('limit');

        $params = [
            'user_id' => $userID,
            'full_name' => $fullName,
            'limit' => $limit
        ];
        $friends = $this->userRepository->getFriendByParams($params)->toArray();

        next:
        $this->status = "success";
        $this->message = "get friend by param success";
        $this->code = 200;
        return $this->responseData($friends['friends']);
    }
}
