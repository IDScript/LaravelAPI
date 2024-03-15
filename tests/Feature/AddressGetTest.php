<?php

use App\Models\Address;
use App\Models\Contact;
use Database\Seeders\AddressSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContactSeeder;

test('Address Get success', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();
    $response = $this->get(
        '/api/contacts/' . $address->contact_id . '/addresses/' . $address->id,
        ['Authorization' => 'testToken']
    );

    $response->assertJson([
        "data" => [
            'street' => 'SCBD test test',
            'city' => 'Jakarta Pusat test',
            'province' => 'Jakarta test',
            'country' => 'Indonesia test',
            'postal_code' => '112233',
        ]
    ]);

    $response->assertStatus(200);
});

test('Address Get by Address ID Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();
    $response = $this->get(
        '/api/contacts/' . $address->contact_id . '/addresses/' . $address->id + 1,
        ['Authorization' => 'testToken']
    );

    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $address->id + 1 . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});

test('Address Get by Contact ID Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();
    $response = $this->get(
        '/api/contacts/' . $address->contact_id + 1 . '/addresses/' . $address->id,
        ['Authorization' => 'testToken']
    );

    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $address->contact_id + 1 . " Not Found"
            ]
        ]
    ]);

    $response->assertStatus(404);
});
