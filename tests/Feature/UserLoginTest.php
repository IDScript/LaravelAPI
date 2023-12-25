<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use function PHPUnit\Framework\assertSame;

test('Login success', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->post(
        '/api/login',
        [
            'username' => 'testLogin',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "data" => [
            "name" => "Nama Test Login",
            "username" => "testLogin",
        ]
    ]);

    $user = User::where('username', 'testLogin')->first();
    assertSame($user->token, $response['data']['token']);
    $response->assertStatus(200);
});

test('Login wrong username', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->post(
        '/api/login',
        [
            'username' => 'test Login',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "errors" => [
            "message" => "Wrong username or password!"
        ]
    ]);
    $response->assertStatus(401);
});

test('Login wrong password', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->post(
        '/api/login',
        [
            'username' => 'testLogin',
            'password' => 'rahasiayaa',
        ]
    );

    $response->assertJson([
        "errors" => [
            "message" => "Wrong username or password!"
        ]
    ]);
    $response->assertStatus(401);
});

test('Login BadRequest', function () {
    $response = $this->post('/api/login');

    $response->assertJson([
        "errors" => [
            "username" => [
                "The username field is required."
            ],
            "password" => [
                "The password field is required."
            ]
        ]
    ]);
    $response->assertStatus(400);
});
