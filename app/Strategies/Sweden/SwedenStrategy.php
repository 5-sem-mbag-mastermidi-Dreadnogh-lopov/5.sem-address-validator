<?php

namespace App\Strategies\Sweden;

use App\lib\Integrations\DawaProvider;
use App\Models\AddressRequest;
use App\Strategies\Strategy;

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
