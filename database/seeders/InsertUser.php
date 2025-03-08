<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class InsertUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('vi_VN'); // Chỉ định Faker sử dụng tiếng Việt

        // Tạo 10 user giả
        for ($i = 0; $i < 200; $i++) {
            $prefix = $faker->randomElement(['09', '03', '08', '07']);

            // Sinh số điện thoại bắt đầu với prefix và kết hợp với 8 chữ số ngẫu nhiên
            $phone = $prefix . $faker->numberBetween(10000000, 99999999);

            DB::table('users')->insert([
                'phone' => $phone, // Sinh số điện thoại ngẫu nhiên
                'email' => $faker->email,
                'full_name' => $faker->name,
                'address' => $faker->address,
                'education_info' => $faker->sentence,
                'work_info' => $faker->sentence,
                'gender' => $faker->randomElement([0, 1]), // 0: nữ, 1: nam
                'relationship' => $faker->randomElement([0, 1, 2]), // 0: độc thân, 1: đã kết hôn, 2: khác
                'dob' => $faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d H:i:s'),
                'password' => bcrypt('12345678'), // Mật khẩu đã mã hóa
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
            echo "insert user $i\n";
        }
    }
}
