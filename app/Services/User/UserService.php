<?php

namespace App\Services\User;

use App\Models\Image;
use App\Models\User;
use App\Repositories\Images\ImageRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\BaseService;

use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class UserService extends BaseService implements IUserServiceInterface
{
    protected UserRepositoryInterface $userRepo;
    protected ImageRepository $imageRepo;
    public function __construct(
        UserRepositoryInterface $userRepo,
        ImageRepository $imageRepo
    )
    {
        $this->userRepo = $userRepo;
        $this->imageRepo = $imageRepo;
    }

    public function insertUser()
    {
        $faker = Faker::create('vi_VN');

        $firstname = $faker->firstName;
        $surname = $faker->lastName;
        $dateOfBirth = $faker->date('Y-m-d', '2005-01-01');
        $gender = $faker->randomElement([0, 1]);
        $phone = $faker->unique()->numerify('09########');
        $email = $faker->unique()->safeEmail;
        $password = 'password123';

        $existingUser = $this->userRepo->findByPhoneOrEmail($phone, $email);
        if ($existingUser) {
            Log::warning('User already exists', ['phone' => $phone, 'email' => $email]);
            return ['message' => 'User already exists'];
        }

        // Tạo user mới
        $newUser = [
            'phone'       => $phone,
            'email'       => $email,
            'dob'         => $dateOfBirth,
            'full_name'   => $firstname . " " . $surname,
            'gender'      => $gender,
            'password'    => Hash::make($password),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
        $user = $this->userRepo->create($newUser);
        Log::info('New user created', ['user' => $user]);
        return $user;
    }

    public function updatePoster($userID, $url, $size, $type, $name)
    {
        $user = $this->userRepo->find($userID);
        if (!$user) {
            return [false, "user not found", null];
        }

        $image = new Image();
        $image->fill([
            Image::_PATH => $url,
            Image::_TYPE => $type,
            Image::_SIZE => $size,
            Image::_ORIGIN_NAME => $name,
            Image::_CREATED_AT => now(),
            Image::_UPDATED_AT => now(),
        ]);
        $image->save();
        if (isset($image[Image::_ID])){
            $this->userRepo->update($userID,[
                User::_POSTER => $image[Image::_ID]
            ]);
        }
        return [true, "update poster success", $image];
    }
}
