<?php

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;

test('Contact Get success', function () {
    $data =  [
        "first_name" => "FirstName",
        "last_name" => "FirstName",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);

    $contact = Contact::first();
    $response = $this->get('/api/contacts/' . $contact->id, ['Authorization' => 'testToken']);
    $response->assertJson(["data" => $data]);

    $response->assertStatus(200);
});

test('Contact Get Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::first();
    $response = $this->get('/api/contacts/' . $contact->id + 1, ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $contact->id + 1 . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});

test('Contact Get Other User Contact', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::first();
    $response = $this->get('/api/contacts/' . $contact->id + 1, ['Authorization' => 'testToken2']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $contact->id + 1 . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});
