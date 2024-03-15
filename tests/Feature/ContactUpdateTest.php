<?php

use App\Models\Contact;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContactSeeder;

test('Contact Update success', function () {
    $data =  [
        "first_name" => "First Name",
        "last_name" => "First Name",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);

    $contact = Contact::first();
    $response = $this->put('/api/contacts/' . $contact->id, $data, ['Authorization' => 'testToken']);
    $response->assertJson(["data" => $data]);

    $response->assertStatus(200);
});

test('Contact Update Fail', function () {
    $data =  [
        "last_name" => "First Name",
        "email" => "emailemail.com",
        "phone" => "098760000000000000054321",
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);

    $contact = Contact::first();
    $response = $this->put('/api/contacts/' . $contact->id, $data, ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "first_name" => ["The first name field is required."],
            "email" => ["The email field must be a valid email address."],
            "phone" => ["The phone field must not be greater than 20 characters."],
        ]
    ]);

    $response->assertStatus(400);
});

test('Contact Update Not Found', function () {
    $data =  [
        "first_name" => "First Name",
        "last_name" => "First Name",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);

    $contact = Contact::first();
    $response = $this->put('/api/contacts/' . $contact->id, $data, ['Authorization' => 'testToken2']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $contact->id . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});
