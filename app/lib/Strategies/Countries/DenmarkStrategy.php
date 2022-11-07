<?php

namespace App\lib\Strategies\Countries;

use App\lib\Strategies\Strategy;
use App\lib\Providers\DawaProvider;
use App\lib\Model\Address;

class DenmarkStrategy implements Strategy
{
    function ValidateAddress(Address $address)
    {
        $provider = new DawaProvider();
        return $provider->ValidateAddress($address);
    }
}
