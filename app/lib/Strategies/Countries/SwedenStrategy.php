<?php

namespace App\lib\Strategies\Countries;

use App\lib\Strategies\Strategy;
use App\lib\Providers\DawaProvider;
use App\Models\AddressRequest;

/**
 * Temporary to test strategies
 */
class SwedenStrategy implements Strategy
{
    function ValidateAddress(AddressRequest $address)
    {
        $provider = new DawaProvider();
        return $provider->ValidateAddress($address);
    }
}
