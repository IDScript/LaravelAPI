<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'username' => 'testLogin',
            'name' => 'Nama Test Login',
            'token' => 'testToken',
            'password' => Hash::make('rahasiaya'),
        ]);

        User::create([
            'username' => 'testLogin2',
            'name' => 'Nama Test Login 2',
            'token' => 'testToken2',
            'password' => Hash::make('rahasiaya'),
        ]);
    }
}
