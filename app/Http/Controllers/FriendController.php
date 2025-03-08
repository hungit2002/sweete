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

        $friends = $this->friendRepository->getByUserID($userID)->toArray();
        $friendIDs = array_column($friends, Friend::_FRIEND_ID);

        $select = [
            User::_ID,
            User::_PHONE,
            User::_EMAIL,
            User::_FULLNAME,
            User::_ADDRESS,
            User::_EDUCATION_INFO,
            User::_WORK_INFO,
            User::_GENDER,
            User::_RELATIONSHIP,
            User::_DOB,
            User::_AVATAR,
            User::_POSTER
        ];
        $param = [
            'full_name' => $fullName,
            'ids' => $friendIDs,
        ];
        if (isset($limit)) {
            $param['limit'] = $limit;
        }
        $users = $this->userRepository->getListByParams($param, $select)->toArray();
        next:
        $this->status = "success";
        $this->message = "get friend by param success";
        $this->code = 200;
        return $this->responseData($users);
    }
}
