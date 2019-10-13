<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\City;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('12345678') , // password
        'remember_token' => Str::random(10),
        'city_id' => mt_rand(1, 5),
        'country_id' => mt_rand(1, 5),
    ];
});


$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'guard_name' => $faker->name
    ];
});

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'country_id' => mt_rand(1, 5)
    ];
});
