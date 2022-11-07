<?php

namespace App\lib\Providers;

use App\lib\Model\Address;
use Illuminate\Support\Facades\Http;

class DawaProvider implements Provider
{
    protected mixed $client;
    protected string $base_url = 'https://api.dataforsyningen.dk/';

    function ValidateAddress(Address $address)
    {
        $response = Http::get($this->base_url . 'datavask/adresser', [
            'betegnelse' => $this->get_attributes($address)
        ]);
        return $response->json();
    }

    public static function get_attributes(Address $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city} {$address->state}";
    }
}
