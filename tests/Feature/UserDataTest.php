<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use function PHPUnit\Framework\assertSame;

test('Get success', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->get('/api/user/current', [
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
});

test('Get Unautorized', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->get('/api/user/current');

    $response->assertJson([
        "errors" => [
            "message" => "Unautorized"
        ]
    ]);

    $response->assertStatus(401);
});

test('Get Invalid Token', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->get('/api/user/current', [
        'Authorization' => 'test Token'
    ]);

    $response->assertJson([
        "errors" => [
            "message" => "Unautorized"
        ]
    ]);

    $response->assertStatus(401);
});
