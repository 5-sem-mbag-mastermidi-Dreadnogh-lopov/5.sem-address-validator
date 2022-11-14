<?php

namespace App\lib\Providers;

use App\Models\AddressRequest;
use App\Models\AddressResponse;

interface Provider
{
    function ValidateAddress(AddressRequest $address) : AddressResponse;
}
