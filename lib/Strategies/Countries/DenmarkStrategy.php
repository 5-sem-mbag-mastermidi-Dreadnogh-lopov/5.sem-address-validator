<?php

namespace lib\strategies\countries;

use lib\strategies\strategy;
use lib\Address;

class DenmarkStrategy implements strategy
{
    function ValidateAddress(Address $address)
    {
        return new Address();
    }
}
