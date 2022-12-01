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
        $records = [
            $this->createAddressRequest(1, '{"city": "Aalborg", "state": "Danmark", "street": "Fyrkildevej 104 1. tv.", "zip_code": "9220", "country_code": "DK"}', 1),
            $this->createAddressRequest(2, '{"city": "Aalborg", "state": "Danmark", "street": "Aalborgvej 100", "zip_code": "9000", "country_code": "DK"}', 2)
        ];
        HashRequest::insert($records);
    }

    public function createAddressRequest (int $id, string $hash_key, int $address_id ): array
    {
        return [
            'id' => $id,
            'hash_key' => $hash_key,
            'address_id' => $address_id
        ];
    }

}
