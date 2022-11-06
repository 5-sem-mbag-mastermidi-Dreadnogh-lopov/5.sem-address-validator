<?php

namespace lib;

interface strategy
{
    function ValidateAddress(Address $address);
}

class DawaStrategy implements strategy
{
    function ValidateAddress(Address $address)
    {
        return new Address();
    }
}
