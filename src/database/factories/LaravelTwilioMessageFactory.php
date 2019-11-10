<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Rocky\LaravelTwilio\Models\LaravelTwilioMessage::class, function (Faker $faker) {
    return [
        'type'     => 'sms',
        'receiver' => $faker->phoneNumber,
        'sender'   => $faker->phoneNumber,
        'text'     => $faker->text,
        'status'   => 'queued',
    ];
});
