<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\StudentModel;
use Faker\Generator as Faker;

$factory->define(StudentModel::class, function (Faker $faker) {
    return [
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
        "joining_session" => $this->faker->randomElement([
            "2016/17",
            "2017/18",
            "2018/19",
            "2019/20"
        ]),
        'home_address' => $faker->address,
        'state' => $faker->state,
        "class" => $this->faker->randomElement([
            "1",
            "2",
            "3",
            "4",
            "5",
            "6"
        ]),
        'guardian_name' => $faker->name,
        'guardian_phone' => $faker->phoneNumber,
        'guardian_email' => $faker->email,
        'guardian_address' => $faker->address,
        'image_url' => '',
    ];
});
