<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'contact_name' => $faker->name,
        'contact_email' => $faker->unique()->safeEmail,
    ];
});
