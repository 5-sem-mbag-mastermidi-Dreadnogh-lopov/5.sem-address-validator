<?php

namespace App\Http\Controllers;

use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Models\HashRequest;
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

        // check cache for identical request, else create new instance of hash request class
        $hash = HashRequest::firstOrNew(
            ['hash_key' => hash('sha256', json_encode($request->all()))],
            ['address_id' => null]
        );

        // verify if there was a record in the database
        if (isset($hash->id)) {
            $res = AddressResponse::find($hash->address_id);
        } else {

            // create address instance from request information
            $address = new AddressRequest($request->all());
            // get the appropriate country strategy and validate the address instance
            $strategy = AddressController::getStrategy($address);
            $res = $strategy->ValidateAddress($address);

            // create result on database and set address id on hash request
            $address_model = AddressResponse::create($res->attributesToArray());
            $hash->address_id = $address_model->id;
            $hash->save();
        }

        return $res;
    }

    /**
     * @param AddressRequest $address
     * @return Strategy
     * @throws Exception
     */
    private static function getStrategy(AddressRequest $address): Strategy
    {
        return match ($address->country_code) {
            'DK' => new DenmarkStrategy(),
            'SE' => new SwedenStrategy(),
            default => throw new Exception('Country not supported'), // or return generic strategy using global services like google-maps
        };
    }
}
