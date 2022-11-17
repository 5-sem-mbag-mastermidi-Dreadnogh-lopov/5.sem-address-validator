<?php

namespace App\Integrations\Dawa;

use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Facades\Http;

class DawaProvider implements Provider
{
    protected string $base_url = 'https://api.dataforsyningen.dk/';

    public function __construct()
    {
    }

    public function geocodeQuery(object $query): Provider
    {
        return "123";
    }

    public function getName(): string
    {
        return 'Dawa';
    }

    function ValidateAddress(AddressRequest $address): AddressResponse
    {
        $response = Http::get($this->base_url . 'datavask/adresser', [
            'betegnelse' => $this->get_attributes($address)
        ])->json();

        $res = new AddressResponse();
        $res->category = $response['kategori'];
        $res->address_id = $response['resultater'][0]['aktueladresse']['id'];
        $res->street = $response['resultater'][0]['aktueladresse']['vejnavn'];

        return $res;
    }

    public static function get_attributes(AddressRequest $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }
}
