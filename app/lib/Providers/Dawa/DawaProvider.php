<?php

namespace App\lib\Providers\Dawa;

use App\lib\Providers\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Facades\Http;

class DawaProvider implements Provider
{
    protected string $base_url = 'https://api.dataforsyningen.dk/';

    public function __construct()
    {
    }

    public function geocodeQuery(object $query) : Provider
    {
        return "123";
    }

    public function getName(): string
    {
        return 'Dawa';
    }

    function ValidateAddress(AddressRequest $address) : AddressResponse
    {
        $response = Http::get($this->base_url . 'datavask/adresser', [
            'betegnelse' => $this->get_attributes($address)
        ])->json();

        $res = new AddressResponse();
        $res->category = $response['kategori'];

        return $res;
    }

    public static function get_attributes(AddressRequest $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }
}
