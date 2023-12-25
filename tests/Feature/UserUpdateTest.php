<?php

use App\Models\User;
use Database\Seeders\UserSeeder;

use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertNotSame;
use function PHPUnit\Framework\assertSame;

test('Update Name Success', function () {
    $this->seed([UserSeeder::class]);
    $oldUser = User::where('token', 'testToken')->first();
    $response = $this->patch('/api/user', [
        "name" => "nama baru"
    ], [
        'Authorization' => 'testToken'
    ]);

    $response->assertJson([
        "data" => [
            "name" => "nama baru",
            "username" => "testLogin",
            "token" => "testToken"
        ]
    ]);
    $response->assertStatus(200);

    $newUser = User::where('token', 'testToken')->first();

    assertNotSame($newUser->name, $oldUser->name);
});

test('Update Password Success', function () {
    $this->seed([UserSeeder::class]);
    $oldUser = User::where('token', 'testToken')->first();
    $response = $this->patch('/api/user', [
        "password" => "password baru"
    ], [
        'Authorization' => 'testToken'
    ]);

    $response->assertJson([
        "data" => [
            "name" => "Nama Test Login",
            "username" => "testLogin",
            "token" => "testToken"
        ]
    ]);
    $response->assertStatus(200);

    $newUser = User::where('token', 'testToken')->first();

    assertNotSame($newUser->password, $oldUser->password);
});

test('Update Name & Password Success', function () {
    $this->seed([UserSeeder::class]);
    $oldUser = User::where('token', 'testToken')->first();
    $response = $this->patch('/api/user', [
        "name" => "nama baru",
        "password" => "password baru"
    ], [
        'Authorization' => 'testToken'
    ]);

    $response->assertJson([
        "data" => [
            "name" => "nama baru",
            "username" => "testLogin",
            "token" => "testToken"
        ]
    ]);
    $response->assertStatus(200);

    $newUser = User::where('token', 'testToken')->first();
    assertNotSame($newUser->name, $oldUser->name);
    assertNotSame($newUser->password, $oldUser->password);
});

test('Update Unautorized', function () {
    $this->seed([UserSeeder::class]);
    $oldUser = User::where('token', 'testToken')->first();
    $response = $this->patch('/api/user');

    $response->assertJson([
        "errors" => [
            "message" => "Unautorized"
        ]
    ]);
    $response->assertStatus(401);

    $newUser = User::where('token', 'testToken')->first();
    assertSame($newUser->name, $oldUser->name);
    assertSame($newUser->password, $oldUser->password);
});

test('Update Password fail', function () {
    $this->seed([UserSeeder::class]);
    $oldUser = User::where('token', 'testToken')->first();
    $response = $this->patch('/api/user', [
        "password" => "pass"
    ], [
        'Authorization' => 'testToken'
    ]);

    $response->assertJson([
        "errors" => [
            "password" => ["The password field must be at least 8 characters."],
        ]
    ]);
    $response->assertStatus(400);

    $newUser = User::where('token', 'testToken')->first();

    assertSame($newUser->password, $oldUser->password);
});
