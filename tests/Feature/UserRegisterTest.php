<?php

test('Register success', function () {
    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "data" => [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
        ]
    ]);
    $response->assertStatus(201);
});

test('Register BadRequest', function () {
    $response = $this->post('/api/register');

    $response->assertJson([
        "errors" => [
            "username" => [
                "The username field is required."
            ],
            "password" => [
                "The password field is required."
            ],
            "name" => [
                "The name field is required."
            ]
        ]
    ]);
    $response->assertStatus(400);
});

test('Register blank name', function () {
    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "errors" => [
            "name" => [
                "The name field is required."
            ]
        ]
    ]);
    $response->assertStatus(400);
});

test('Register blank username', function () {
    $response = $this->post(
        '/api/register',
        [
            'name' => 'Nama Test Daftar',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "errors" => [
            "username" => [
                "The username field is required."
            ]
        ]
    ]);
    $response->assertStatus(400);
});

test('Register blank password', function () {
    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
        ]
    );

    $response->assertJson([
        "errors" => [
            "password" => [
                "The password field is required."
            ]
        ]
    ]);
    $response->assertStatus(400);
});

test('Register password not enough', function () {
    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
            'password' => 'rahasia',
        ]
    );

    $response->assertJson([
        "errors" => [
            "password" => [
                "The password field must be at least 8 characters."
            ]
        ]
    ]);
    $response->assertStatus(400);
});

test('Register Username Already Registered', function () {
    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "data" => [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
        ]
    ]);

    $response->assertStatus(201);

    $response = $this->post(
        '/api/register',
        [
            'username' => 'testDaftar',
            'name' => 'Nama Test Daftar',
            'password' => 'rahasiaya',
        ]
    );

    $response->assertJson([
        "errors" => "Username Already Registered"
    ]);

    $response->assertStatus(400);
});
