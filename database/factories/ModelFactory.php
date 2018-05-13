<?php

use Faker\Factory;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\Http\WechatAuth\Models\WechatUser::class, function (Faker\Generator $faker) {
    return [
        'openid' => $faker->md5,
        'realname' => $faker->name,
        'nickname' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'headimgurl' => $faker->imageurl(100, 100),
        'address' => $faker->address,
        'gender' => $faker->numberBetween(0, 2),
        'city' => $faker->city,
        'country' => $faker->country,
        'province' => $faker->city,
    ];
});
