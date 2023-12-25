<?php

use Database\Seeders\UserSeeder;

test('Contact Add success', function () {
    $data =  [
        "first_name" => "FirstName",
        "last_name" => "FirstName",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class]);
    $response = $this->post('/api/contact', $data, ['Authorization' => 'testToken']);
    $response->assertJson(["data" => $data]);

    $response->assertStatus(201);
});

test('Contact Add Fail', function () {
    $data =  [
        "last_name" => "FirstName",
        "email" => "emailemail.com",
        "phone" => "09876543200000000000001",
    ];

    $this->seed([UserSeeder::class]);
    $response = $this->post('/api/contact', $data, ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "first_name" => ["The first name field is required."],
            "email" => ["The email field must be a valid email address."],
            "phone" => ["The phone field must not be greater than 20 characters."],
        ]
    ]);

    $response->assertStatus(400);
});

test('Contact Add Unautorized', function () {
    $data =  [
        "first_name" => "FirstName",
        "last_name" => "FirstName",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class]);
    $response = $this->post('/api/contact', $data, ['Authorization' => 'test Token']);
    $response->assertJson(["errors" => ["message" => "Unautorized"]]);

    $response->assertStatus(401);
});
