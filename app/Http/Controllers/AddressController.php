<?php

namespace App\Http\Controllers;

use App\Integrations\Confidence;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Models\HashRequest;
use App\Strategies\Denmark\DenmarkStrategy;
use App\Strategies\Norway\NorwayStrategy;
use App\Strategies\Strategy;
use App\Strategies\Sweden\SwedenStrategy;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected Strategy $strategy;

    /**
     * @param Request $request
     * @return AddressResponse
     * @throws Exception
     */

    public function index(Request $request): AddressResponse
    {
        $request->validate([
            'street'       => 'required',
            'country_code' => 'required|max:2',
            'zip_code'     => 'required'
        ]);

        // Get all attributes and sort them, so they can match in the cache DB
        $request_attributes = $request->only(
            [
                'street',
                'state',
                'zip_code',
                'city',
                'country_code'
            ]
        );
        ksort($request_attributes);

        // check cache for identical request, else create new instance of hash request class
        $hash = HashRequest::firstOrNew(
            [
                'hash_key' => hash(env('HASH_ALGO'), json_encode($request_attributes)),
                'request'  => json_encode($request_attributes)
            ],
            ['address_id' => null]
        );

        // verify if there was a record in the database
        if (isset($hash['id'])) {
            $res = AddressResponse::find($hash['address_id']);
        } else {
            // create address instance from request information
            $address = new AddressRequest($request->all());

            // get the appropriate country strategy and validate the address instance
            $strategy = AddressController::getStrategy($address);
            $res = $strategy->validateAddress($address);
            if($res->confidence !== Confidence::Unknown){
                $address_model = AddressResponse::firstOrCreate([
                    'street_name'   => $res->street_name,
                    'street_number' => $res->street_number,
                    'zip_code'      => $res->zip_code,
                    'city'          => $res->city
                ], $res->attributesToArray());
                $hash['address_id'] = $address_model['id'];
                $hash->save();
            }
            // create result on database and set address id on hash request

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
            'NO' => new NorwayStrategy(),
            default => throw new Exception('Country not supported'), // or return generic strategy using global services like google-maps
        };
    }
}
