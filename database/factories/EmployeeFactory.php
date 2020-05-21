<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {

	$gender = $faker->randomElement(['male','female']);

    return [
         'firstName' => $faker->name,
         'lastName' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => $gender,
        'dateOfBirth' => $faker->dateTimeBetween('1990-01-01', '2007-12-31')->format('Y-m-d'),
        'hiredOn' => $faker->dateTimeBetween('2016-01-01','2020-03-31')->format('Y-m-d'),
    ];
});
