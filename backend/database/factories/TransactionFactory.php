<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomDigit(),
        'unit' => 'day',
        'description' => 'API Development',
        'unit_cost' => $faker->randomFloat(2, 0, 10000),
        'invoice_id' => $faker->randomElement(App\Invoice::pluck('id')->toArray()),
    ];
});
