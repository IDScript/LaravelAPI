<?php

use Database\Seeders\SearchSeeder;
use Database\Seeders\UserSeeder;

use function PHPUnit\Framework\assertEquals;

test('Contact Search by First Name', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?name=first', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();

    assertEquals(10, count($response['data']));
    assertEquals(20, $response['meta']['total']);
});

test('Contact Search by Last Name', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?name=last', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();

    assertEquals(10, count($response['data']));
    assertEquals(20, $response['meta']['total']);
});

test('Contact Search by Email', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?email=email', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();

    assertEquals(10, count($response['data']));
    assertEquals(20, $response['meta']['total']);
});

test('Contact Search by Phone', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?phone=0987654321', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();

    assertEquals(10, count($response['data']));
    assertEquals(20, $response['meta']['total']);
});

test('Contact Search Not Found', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?name=kosong', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();

    assertEquals(0, count($response['data']));
    assertEquals(0, $response['meta']['total']);
});

test('Contact Search by with Page', function () {
    $this->seed([UserSeeder::class, SearchSeeder::class]);
    $response = $this->get('/api/contacts?size=5&page=2', ['Authorization' => 'testToken']);
    $response->assertStatus(200)->json();
    assertEquals(5, count($response['data']));
    assertEquals(2, $response['meta']['current_page']);
    assertEquals(20, $response['meta']['total']);
});
