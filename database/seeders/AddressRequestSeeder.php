<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('hash_request')->insert([
            'id' => 1,
            'hash_key' => '{"city": "Aalborg", "state": "Danmark", "street": "Fyrkildevej 104 1. tv.", "zip_code": "9220", "country_code": "DK"}',
            'address_id' => 1
        ]);
    }
}
