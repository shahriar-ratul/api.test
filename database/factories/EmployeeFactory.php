<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\model\Company;
use App\model\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            return Company::all()->random();
        },
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,

    ];
});
