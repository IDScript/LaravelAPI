<?php

use App\Models\User;
use Database\Seeders\UserSeeder;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertSame;

test('Logout Success', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->delete('/api/logout', [], [
        'Authorization' => 'testToken'
    ]);
    $response->assertStatus(204);
    $user = User::where('username', 'testLogin')->first();
    assertNull($user->token);
});

test('Logout Unautorized', function () {
    $this->seed([UserSeeder::class]);
    $response = $this->delete('/api/logout', [], [
        'Authorization' => 'salah'
    ]);
    $response->assertJson([
        "errors" => [
            "message" => "Unautorized"
        ]
    ]);
    $response->assertStatus(401);
    $user = User::where('username', 'testLogin')->first();
    assertNotNull($user->token);
});
