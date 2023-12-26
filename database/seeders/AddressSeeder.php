<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $contact = Contact::limit(1)->first();

        Address::create([
            'contact_id' => $contact->id,
            'street' => 'SCBD test test',
            'city' => 'Jakarta Pusat test',
            'province' => 'Jakarta test',
            'country' => 'Indonesia test',
            'postal_code' => '112233',
        ]);
    }
}
