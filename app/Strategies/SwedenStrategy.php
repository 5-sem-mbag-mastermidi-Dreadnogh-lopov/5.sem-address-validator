<?php

namespace App\Strategies;

use App\lib\Integrations\DawaProvider;
use App\Models\AddressRequest;

/**
 * Temporary to test strategies
 */
class SwedenStrategy implements Strategy
{
    function validateAddress(AddressRequest $address)
    {
        $provider = new DawaProvider();
        return $provider->ValidateAddress($address);
    }
}
