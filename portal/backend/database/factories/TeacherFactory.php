<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\TeacherModel;
use Faker\Generator as Faker;

$factory->define(TeacherModel::class, function (Faker $faker) {
    return [
        'title' => $this->faker->randomElement([
            "MR",
            "MRS",
            "MISS",
        ]),
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        "gender" => $this->faker->randomElement([
            "MALE",
            "FEMALE",
        ]),
        "religion" => $this->faker->randomElement([
            "MUSLIM",
            "CHRISTIAN",
        ]),
        'dob' => $faker->date('d-m-Y'),
        'joining_date' => $faker->date('d-m-Y'),
        'state' => $faker->state,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'image_url' => '',
        'home_address' => $faker->address,
        'assigned_class' => '',
    ];
});
