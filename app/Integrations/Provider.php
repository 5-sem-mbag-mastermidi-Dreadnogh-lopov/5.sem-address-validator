<?php

namespace App\Integrations;

use App\Models\AddressRequest;
use App\Models\AddressResponse;

interface Provider
{
    function ValidateAddress(AddressRequest $address, array|AddressRequest $wash_results): AddressResponse;
}
