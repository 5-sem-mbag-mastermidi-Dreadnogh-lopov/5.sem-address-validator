<?php

namespace App\Strategies\AddressRequest;

use App\Models\AddressRequest;
use Faker\Provider\Address;

interface AddressRequestRuleInterface
{
    public function apply(AddressRequest $request) : AddressRequest;
}
