<?php

namespace App\lib\Providers;

use App\lib\Model\Address;

interface Provider
{
    function ValidateAddress(Address $address);
}
