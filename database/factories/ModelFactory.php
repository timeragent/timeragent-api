<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Models\Organization;
use App\Models\User;
use Ramsey\Uuid\Uuid;

$factory->define(
    User::class, function (Faker\Generator $faker) {
    return [
        'uuid'           => Uuid::uuid4()->toString(),
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->lastName,
        'middle_name'    => null,
        'email'          => $faker->email,
        'password'       => $faker->password,
        'verified'       => $faker->boolean,
        'remember_token' => $faker->password(100, 100),
        'created_at'     => $faker->dateTime,
    ];
}
);

$factory->define(
    Organization::class, function (Faker\Generator $faker) {
    return [
        'uuid'    => Uuid::uuid4()->toString(),
        'name'    => $faker->streetName,
        'address' => $faker->address,
        'phone'   => $faker->phoneNumber,
        'email'   => $faker->email,
        'website' => $faker->domainName,
    ];
}
);
