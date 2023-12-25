<?php

use App\Models\Contact;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContactSeeder;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertEquals;

test('Contact Delete success', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $oldContact = Contact::first();
    $response = $this->delete('/api/contact/' . $oldContact->id, [], ['Authorization' => 'testToken']);
    $response->assertStatus(204);
    $newContact = Contact::where('id', $oldContact->id)->first();
    assertNull($newContact);
});

test('Contact Delete Other User', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $oldContact = Contact::first();
    $response = $this->delete('/api/contact/' . $oldContact->id, [], ['Authorization' => 'testToken2']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $oldContact->id . " Not Found"
            ]
        ]
    ]);
    $response->assertStatus(404);
    $newContact = Contact::where('id', $oldContact->id)->first();
    assertEquals($oldContact, $newContact);
});

test('Contact Delete Not Found', function () {
    $this->seed([UserSeeder::class, ContactSeeder::class]);
    $oldContact = Contact::first();
    $response = $this->delete('/api/contact/' . $oldContact->id + 1, [], ['Authorization' => 'testToken2']);
    $response->assertJson([
        "errors" => [
            "message" => [
                "Id:" . $oldContact->id + 1 . " Not Found"
            ]
        ]
    ]);
    $response->assertStatus(404);
});
