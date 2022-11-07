<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use lib\Address;
use lib\strategies\countries\DenmarkStrategy;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $address = new Address();

        $address->country_code = $request->country_code;

        $strategy = match ($address->country_code) {
            'DK' => new DenmarkStrategy(),
            'SE' => new DenmarkStrategy(),
            default => throw new Exception('Country not supported'),
        };

        return $strategy->ValidateAddress($address);
    }
}
