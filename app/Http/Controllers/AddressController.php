<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\lib\Model\Address;
use App\lib\Strategies\Countries\DenmarkStrategy;
use App\lib\Strategies\Countries\SwedenStrategy;
use App\lib\Strategies\Strategy;

class AddressController extends Controller
{
    protected Strategy $strategy;

    public function index(Request $request)
    {
        $address = new Address();

        $address->country_code = $request->country_code;
        $address->street = $request->street;
        $address->zip_code = $request->zip_code;
        $address->city = $request->city;


        $strategy = match ($address->country_code) {
            'DK' => new DenmarkStrategy(),
            'SE' => new SwedenStrategy(),
            default => throw new Exception('Country not supported'),
        };

        return $strategy->ValidateAddress($address);
    }
}
