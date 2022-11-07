<?php

namespace App\lib\Strategies;

use app\lib\model\Address;

interface Strategy
{
    function ValidateAddress(Address $address);
}
