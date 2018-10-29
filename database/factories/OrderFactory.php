<?php

use Faker\Generator as Faker;

// we can use it to generate fake model data that we can use to fill our development database and tests
$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'title' => 'Need a coffee to Bunraby Libaray',
        'description' => 'Thanks Amigo!',
        'item' => 'Stackbucks Coffee',
        'owner' => 'Andrew Yang',
        'taker' => 'Jacky Liu',
    ];
});
