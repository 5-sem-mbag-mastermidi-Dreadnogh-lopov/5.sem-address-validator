<?php

namespace App\lib\Providers\Dawa;

use App\Models\Address;
use App\Models\DawaAddress;
use Geocoder\Collection;
use Geocoder\Model\AddressCollection;
use Geocoder\Provider\Provider;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Query\ReverseQuery;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Http;

class DawaProvider implements Provider
{
    protected mixed $client;
    protected string $base_url = 'https://api.dataforsyningen.dk/';

    public function __construct()
    {
    }

    public function geocodeQuery(GeocodeQuery $query): Collection
    {
        $addresses = new SupportCollection();

        return new AddressCollection($addresses->map(function (Address $address) {
            return new DawaAddress($address);
        })->all());
    }

    public function reverseQuery(ReverseQuery $query): Collection
    {
        return new AddressCollection();
    }

    public function getName(): string
    {
        return 'Dawa';
    }

    function ValidateAddress(Address $address)
    {
        $response = Http::get($this->base_url . 'datavask/adresser', [
            'betegnelse' => $this->get_attributes($address)
        ]);

        return $response->json();
    }

    public static function get_attributes(Address $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }
}
