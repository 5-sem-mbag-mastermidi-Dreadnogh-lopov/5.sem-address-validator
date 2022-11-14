<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\AddressRequest;
use App\lib\Strategies\Countries\DenmarkStrategy;
use App\lib\Strategies\Countries\SwedenStrategy;
use App\lib\Strategies\Strategy;

class AddressController extends Controller
{
    protected Strategy $strategy;

    public function index(Request $request)
    {
        $request->validate([
            'street' => 'required',
            'country_code' => 'required|max:2',
            'zip_code' => 'required'
        ]);

        $address = new AddressRequest($request->all());

        $strategy = match ($address->country_code) {
            'DK' => new DenmarkStrategy(),
            'SE' => new SwedenStrategy(),
            default => throw new Exception('Country not supported'),
        };

        return $strategy->ValidateAddress($address);
    }
}
