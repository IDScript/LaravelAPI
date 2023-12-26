<?php

use App\Models\Contact;
use Database\Seeders\UserSeeder;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;

test('Contact List success', function () {
    $data =  [
        'street' => 'SCBD test test',
        'city' => 'Jakarta Pusat test',
        'province' => 'Jakarta test',
        'country' => 'Indonesia test',
        'postal_code' => '112233',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

    $contact = Contact::first();
    $response = $this->get('/api/contacts/' . $contact->id . '/addresses', ['Authorization' => 'testToken']);
    $response->assertJson(["data" => [$data]]);

    $response->assertStatus(200);
});

test('Address List Contact Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $contact = Contact::first();
    $response = $this->get('/api/contacts/' . $contact->id + 1 . '/addresses', ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $contact->id + 1 . " Not Found"
            ]
        ]
    ]);
    $response->assertStatus(404);
});
