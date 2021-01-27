<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Institution;
use Faker\Generator as Faker;

$factory->define(Institution::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "image" => "some_url"
    ];
});

$factory->state(Institution::class, 'institution', [
    'type' => 'institution',
]);

$factory->state(Institution::class, 'organization', [
    'type' => 'organization',
]);
