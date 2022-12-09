<?php

namespace Database\Seeders;

use App\Models\HashRequest;
use Illuminate\Database\Seeder;

class AddressRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HashRequest::insert($this->createAddressRequestSeed());
    }

    public function createAddressRequestSeed(): array
    {
        return [
            [
                'id'         => 1,
                'hash_key'   => hash('sha256', '{"city":"Aalborg","country_code":"DK","street":"Fyrkildevej 104, 1. tv","zip_code":"9220"}'),
                'request'    => '{"city":"Aalborg","country_code":"DK","street":"Fyrkildevej 104, 1. tv","zip_code":"9220"}',
                'address_id' => 1
            ],
            [
                'id'         => 2,
                'hash_key'   => hash('sha256', '{"city": "København K", "country_code": "DK", "street": "Pilestræde 1", "zip_code": "1112"}'),
                'request'    => '{"city": "København K", "country_code": "DK", "street": "Pilestræde 1", "zip_code": "1112"}',
                'address_id' => 2
            ]
        ];
    }

}
