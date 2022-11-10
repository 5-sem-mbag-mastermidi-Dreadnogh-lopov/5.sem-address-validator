<?php

namespace App\lib\Providers;

use App\Models\Address;

interface Provider
{
    function ValidateAddress(Address $address);
}
