<?php

namespace Database\Seeders;

use App\Repositories\Feel\FeelRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InsertEmoji extends Seeder
{
    private FeelRepositoryInterface $feelRepo;

    public function __construct(
        FeelRepositoryInterface $feelRepo
    )
    {
        $this->feelRepo = $feelRepo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $feelings = [
            ['key' => 1, 'name' => 'Hạnh phúc', 'emoji' => '😊', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 2, 'name' => 'Được yêu', 'emoji' => '😍', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 3, 'name' => 'Đáng yêu', 'emoji' => '🥰', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 4, 'name' => 'Hào hứng', 'emoji' => '🤩', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 5, 'name' => 'Điên', 'emoji' => '🤣', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 6, 'name' => 'Sung sướng', 'emoji' => '😆', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 7, 'name' => 'Khổ cực', 'emoji' => '😖', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 8, 'name' => 'Có phúc', 'emoji' => '🍀', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 9, 'name' => 'Buồn', 'emoji' => '😢', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 10, 'name' => 'Biết ơn', 'emoji' => '🙏', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 11, 'name' => 'Đáng yêu', 'emoji' => '🥰', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 12, 'name' => 'Cảm kích', 'emoji' => '😌', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 13, 'name' => 'Tuyệt vời', 'emoji' => '🤗', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 14, 'name' => 'Vui vẻ', 'emoji' => '😁', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 15, 'name' => 'Hoài niệm', 'emoji' => '🤔', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 16, 'name' => 'Ốm yếu', 'emoji' => '🤒', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 17, 'name' => 'Kiệt sức', 'emoji' => '😩', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 18, 'name' => 'Tự tin', 'emoji' => '😎', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 19, 'name' => 'Tươi mới', 'emoji' => '🌱', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 20, 'name' => 'Hạnh phúc', 'emoji' => '😊', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 21, 'name' => 'Vui vẻ', 'emoji' => '😁', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 22, 'name' => 'Giận dữ', 'emoji' => '😠', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 23, 'name' => 'Hài lòng', 'emoji' => '🙂', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 24, 'name' => 'Xúc động', 'emoji' => '🥹', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 25, 'name' => 'Rất tuyệt', 'emoji' => '🌟', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 26, 'name' => 'Quyết đoán', 'emoji' => '💪', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 27, 'name' => 'Bực mình', 'emoji' => '😤', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 28, 'name' => 'Có phúc', 'emoji' => '🍀', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 29, 'name' => 'Tuyệt vời', 'emoji' => '🤩', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 30, 'name' => 'Thú vị', 'emoji' => '🤓', 'created_at' => $now, 'updated_at' => $now],
        ];

        $this->feelRepo->insert($feelings);
    }
}
