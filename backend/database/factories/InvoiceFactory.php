<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'reference' => $faker->word(),
        'status' => 'draft',
        'client_id' => $faker->randomElement(App\Client::pluck('id')->toArray()),
    ];
});
