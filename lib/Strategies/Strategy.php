<?php

namespace lib\strategies;

use lib\Address;

interface strategy
{
    function ValidateAddress(Address $address);
}
