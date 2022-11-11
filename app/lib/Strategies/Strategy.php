<?php

namespace App\lib\Strategies;

use app\models\Address;

interface Strategy
{
    function ValidateAddress(Address $address);
}
