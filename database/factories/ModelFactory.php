<?php

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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Goods::class, function ($faker) {
    return [
        'goods_uuid' => $faker->sentence(mt_rand(3, 8)),
        'name' =>  $faker->sentence(mt_rand(3, 5)),
        'nums' => 10,
        'description' => $faker->sentence(mt_rand(3, 10)),
		'money' => 100,
        'image_id' => 1,
        'order' => 10,
    ];
});
