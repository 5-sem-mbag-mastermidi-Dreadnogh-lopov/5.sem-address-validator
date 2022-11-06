<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use lib\Address;
use lib\DawaStrategy;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $strategy = null;
        $address = new Address(); {
            $address->country_code = $request->input('country_code');
        }

        if ($address->country_code == 'DK') {
            $strategy = new DawaStrategy();
        } elseif ($address->country_code == 'SE') {
            $strategy = new DawaStrategy();
        }

        $strategy->ValidateAddress($address);
    }
}
