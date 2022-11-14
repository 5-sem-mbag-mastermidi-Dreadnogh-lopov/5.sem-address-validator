<?php

namespace App\lib\Strategies;

use app\models\AddressRequest;

interface Strategy
{
    function ValidateAddress(AddressRequest $address);
}
