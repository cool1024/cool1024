<?php

use Illuminate\Database\Seeder;

use App\Http\WechatAuth\Models\WechatUser;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory;

class WechatUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('zh_CN');

        for ($i = 0; $i < 50; $i++) {
            WechatUser::create([
                'openid' => $faker->md5,
                'realname' => $faker->name,
                'nickname' => $faker->name,
                'mobile' => $faker->phoneNumber,
                'headimgurl' => $faker->imageurl(100, 100),
                'address' => $faker->address,
                'sex' => $faker->numberBetween(0, 2),
                'city' => $faker->city,
                'country' => $faker->country,
                'province' => $faker->city,
            ]);
        }
    }
}
