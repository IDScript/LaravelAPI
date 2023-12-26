<?php

use App\Models\Address;
use Database\Seeders\UserSeeder;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;

test('Address Update success', function () {
    $data =  [
        'street' => 'SCBD baru',
        'city' => 'Jakarta Pusat baru',
        'province' => 'Jakarta baru',
        'country' => 'Indonesia baru',
        'postal_code' => '332211',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();

    $response = $this->put(
        '/api/contacts/' . $address->contact_id . '/addresses/' . $address->id,
        $data,
        ['Authorization' => 'testToken']
    );

    $response->assertJson(["data" => $data]);

    $response->assertStatus(200);
});

test('Address Update Fail', function () {
    $data =  [
        'street' => 'SCBD baru',
        'city' => 'Jakarta Pusat baru',
        'province' => 'Jakarta baru',
        'postal_code' => '332211',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();

    $response = $this->put(
        '/api/contacts/' . $address->contact_id . '/addresses/' . $address->id,
        $data,
        ['Authorization' => 'testToken']
    );

    $response->assertJson([
        "errors" => [
            "country" => ["The country field is required."]
        ]
    ]);

    $response->assertStatus(400);
});

test('Address Update Not Found', function () {
    $data =  [
        'street' => 'SCBD baru',
        'city' => 'Jakarta Pusat baru',
        'province' => 'Jakarta baru',
        'country' => 'Indonesia baru',
        'postal_code' => '332211',
    ];

    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $address = Address::limit(1)->first();

    $response = $this->put(
        '/api/contacts/' . $address->contact_id . '/addresses/' . $address->id + 1,
        $data,
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
