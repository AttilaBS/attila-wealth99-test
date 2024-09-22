<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Coin::class, function (Faker $faker) {
    return [
        'coin_api_id' => $faker->name,
        'name' => $faker->name,
        'symbol' => $faker->name,
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
