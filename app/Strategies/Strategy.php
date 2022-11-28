<?php

namespace App\Strategies;

use app\models\AddressRequest;

interface Strategy
{
    function validateAddress(AddressRequest $address);
}
