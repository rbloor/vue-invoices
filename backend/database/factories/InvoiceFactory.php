<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'reference' => $faker->name,
        'is_paid' => $faker->boolean(),
        'is_sent' => $faker->boolean(),
        'client_id' => $faker->randomElement(App\Client::pluck('id')->toArray()),
    ];
});
