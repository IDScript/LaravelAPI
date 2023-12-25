<?php

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;

test('Contact List success', function () {
    $data =  [
        "first_name" => "FirstName",
        "last_name" => "FirstName",
        "email" => "email@email.com",
        "phone" => "0987654321",
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);

    $contact = Contact::first();
    $response = $this->get('/api/contacts', ['Authorization' => 'testToken']);
    $response->assertJson([$data]);

    $response->assertStatus(200);
});

test('Contact List Blank', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::first();
    $response = $this->get('/api/contacts', ['Authorization' => 'testToken2']);
    $response->assertJson([]);

    $response->assertStatus(200);
});
