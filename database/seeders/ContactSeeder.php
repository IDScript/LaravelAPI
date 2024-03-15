<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user = User::where('username', 'testLogin')->first();
        Contact::create([
            "first_name" => "FirstName",
            "last_name" => "FirstName",
            "email" => "email@email.com",
            "phone" => "0987654321",
            'user_id' => $user->id,
        ]);
    }
}
