<?php

namespace Database\Seeders;

use App\Models\HashRequest;
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
        HashRequest::insert($this->createAddressRequestSeed());
    }

    public function createAddressRequestSeed (): array
    {
        return [
            [
             'id' => 1,
             'hash_key' => '{"city": "Aalborg", "state": "Danmark", "street": "Fyrkildevej 104 1. tv.", "zip_code": "9220", "country_code": "DK"}',
             'address_id' => 1
            ],
            [
             'id' => 2,
             'hash_key' => '{"city": "København K", "state": "Danmark", "street": "Pilestræde 1", "zip_code": "1112", "country_code": "DK"}',
             'address_id' => 2
            ]
        ];
    }

}
