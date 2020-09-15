<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\model\Employee;
use App\model\EmployeeInfo;
use Faker\Generator as Faker;

$factory->define(EmployeeInfo::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            return Employee::all()->random();
        },
        'birthday' => $faker->dateTime,
    ];
});
