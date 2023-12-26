<?php

use App\Models\Address;
use Database\Seeders\UserSeeder;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

test('Address Delete success', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $oldAddress = Address::limit(1)->first();
    $response = $this->delete(
        '/api/contacts/' . $oldAddress->contact_id . '/addresses/' . $oldAddress->id,
        [],
        ['Authorization' => 'testToken']
    );

    $response->assertStatus(204);
    $newAddress = Address::limit(1)->first();
    assertNull($newAddress);
});

test('Address Delete Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);
    $oldAddress = Address::limit(1)->first();
    $response = $this->delete(
        '/api/contacts/' . $oldAddress->contact_id . '/addresses/' . $oldAddress->id + 1,
        [],
        ['Authorization' => 'testToken']
    );

    $response->assertStatus(404);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $oldAddress->id + 1 . " Not Found"
            ]
        ]
    ]);

    $newAddress = Address::limit(1)->first();
    assertEquals($oldAddress, $newAddress);
});
