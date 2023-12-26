<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class SearchSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $user = User::where('username', 'testLogin')->first();
        for ($i = 0; $i < 20; $i++) {
            Contact::create([
                "first_name" => "First" . $i,
                "last_name" => "Last" . $i,
                "email" => "email" . $i . "@email.com",
                "phone" => "0987654321" . $i,
                'user_id' => $user->id,
            ]);
        }
    }
}
