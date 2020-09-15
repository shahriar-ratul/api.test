<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\model\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
            'name' => $faker->name,
    ];
});
