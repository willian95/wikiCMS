<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AdminMail;
use Faker\Generator as Faker;

$factory->define(AdminMail::class, function (Faker $faker) {
    return [
        "email" => $faker->safeEmail
    ];
});
