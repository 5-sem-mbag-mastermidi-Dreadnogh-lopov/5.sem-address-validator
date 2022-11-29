<?php

use App\Models\AddressResponse;
use App\Strategies\Denmark\DenmarkStrategy;
use Illuminate\Support\Collection;

test('Denmark washing', function () {

    $address = new \App\Models\AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark = new DenmarkStrategy();

    $response = $denmark->wash($address);
    $response_type = gettype($denmark->wash($address));
    $response_array = $denmark->wash($address)->toArray();
    $response_array_count = count($response_array);

    $validated_address = $denmark->validateAddress($address);

    expect(gettype($validated_address))->toEqual('object');

    expect($response_array_count)->toEqual(0 < $response_array_count);
    expect($response_type)->toEqual('object');
    expect(gettype($response_array))->toEqual('array');

});
