<?php

namespace App\lib\Strategies\Countries;

use App\lib\Strategies\Strategy;
use App\lib\Providers\Dawa\DawaProvider;
use App\Models\Address;
use Geocoder\Query\GeocodeQuery;
use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GoogleMaps\GoogleMaps;

class DenmarkStrategy implements Strategy
{
    function ValidateAddress(Address $address)
    {
        $query = GeocodeQuery::create($this->get_attributes($address));

        $client  = new \GuzzleHttp\Client();
        $geocoder = new \Geocoder\ProviderAggregator();
        $geocoder->registerProvider(new Chain([
            new DawaProvider(),
            new GoogleMaps($client, 'Denmark'),
        ]));

        $result = $geocoder->geocodeQuery($query);

        // $provider = new DawaProvider();
        // return $provider->ValidateAddress($address);
    }

    public static function get_attributes(Address $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city} {$address->state}";
    }
}
