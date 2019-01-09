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
use App\Models\Team;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\Contact;
use \Illuminate\Support\Facades\Hash;

$factory->define(
    User::class, function (Faker\Generator $faker) {
    return [
        'uuid'               => Uuid::uuid4()->toString(),
        'first_name'         => $faker->firstName,
        'last_name'          => $faker->lastName,
        'middle_name'        => null,
        'email'              => $faker->email,
        'password'           => Hash::make($faker->password),
        'verification_token' => $faker->boolean ? str_random(20) : null,
        'remember_token'     => $faker->password(100, 100),
        'created_at'         => $faker->dateTime,
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

$factory->define(
    Team::class, function (Faker\Generator $faker) {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $faker->company . ' team',
            'owner_type' => $faker->randomElement([
                User::MORPH_NAME,
                Organization::MORPH_NAME,
            ]),
            'owner_uuid' => function($row) {
                if ($row['owner_type'] === User::MORPH_NAME) {
                    return factory(User::class)->create()->uuid;
                } elseif ($row['owner_type'] === Organization::MORPH_NAME) {
                    return factory(Organization::class)->create()->uuid;
                }
                throw new \InvalidArgumentException("Relation type {$row['owner_type']}  is not defined");
            }
        ];
}
);

$factory->define(
    Client::class, function(Faker\Generator $faker) {
        return [
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $faker->company,
            'organization_uuid' => Organization::inRandomOrder()->first(),
            'contact_uuid' => Contact::inRandomOrder()->first(),
            'address' => $faker->streetName,
            'invoice_prefix' => $faker->stateAbbr,
            'rate' => $faker->numberBetween(10,50),
        ];
}
);
