<?php

namespace App\Integrations;

use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Collection;

interface Provider
{
    function validateAddress(AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse;
}
