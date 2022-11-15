<?php

namespace App\Strategies;

use app\models\AddressRequest;

interface Strategy
{
    function ValidateAddress(AddressRequest $address);
}
