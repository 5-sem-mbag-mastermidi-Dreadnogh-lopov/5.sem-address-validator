<?php

namespace App\Http\Controllers;

use App\Models\AddressRequest;
use App\Strategies\DenmarkStrategy;
use App\Strategies\Strategy;
use App\Strategies\SwedenStrategy;
use Exception;
use Illuminate\Http\Request;

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
