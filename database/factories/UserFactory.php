<?php

use App\User;
use App\Category;
use App\Course;
use App\Action;
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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verified = $faker->randomElement([User::USER_VERIFIED, User::USER_NOT_VERIFIED]),
        'verification_token' => $verified == User::USER_VERIFIED ? null : User::generateVerificationToken(),
        'admin' => $verified = $faker->randomElement([User::USER_ADMIN, User::USER_REGULAR]),
    ];
});

$factory->define(Category::class, function (Faker $faker) {

  return [
    'name' => $faker->word,
    'description' => $faker->paragraph(1),
  ];
});

$factory->define(Course::class, function (Faker $faker) {

  return [
    'name' => $faker->word,
    'description' => $faker->paragraph(1),
    'maximum' =>$faker->numberBetween(1,20),
    'status' => $faker->randomElement([Course::COURSE_OPEN, Course::COURSE_CLOSE]),
  ];
});

$factory->define(Action::class, function (Faker $faker) {

  return [
    'name' => $faker->word,
    'student_id' => User::inRandomOrder()->first()->id,
    'course_id' => Course::inRandomOrder()->first()->id,
  ];
});
