<?php

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;

test('Address Add success', function () {
    $data =  [
        'street' => 'SCBD',
        'city' => 'Jakarta Pusat',
        'province' => 'Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '112183',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::limit(1)->first();
    $response = $this->post('/api/contact/' . $contact->id . '/addresses', $data, ['Authorization' => 'testToken']);
    $response->assertJson(["data" => $data]);

    $response->assertStatus(201);
});

test('Address Add Fail', function () {
    $data =  [
        'street' => 'SCBD',
        'city' => 'Jakarta Pusat',
        'province' => 'Jakarta',
        'postal_code' => '112183',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::limit(1)->first();
    $response = $this->post('/api/contact/' . $contact->id . '/addresses', $data, ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "country" => ["The country field is required."]
        ]
    ]);

    $response->assertStatus(400);
});

test('Address Add Not Found', function () {
    $data =  [
        'street' => 'SCBD',
        'city' => 'Jakarta Pusat',
        'province' => 'Jakarta',
        'country' => 'Indonesia',
        'postal_code' => '112183',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $contact = Contact::limit(1)->first();
    $response = $this->post('/api/contact/' . $contact->id + 1 . '/addresses', $data, ['Authorization' => 'testToken']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $contact->id + 1 . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});
