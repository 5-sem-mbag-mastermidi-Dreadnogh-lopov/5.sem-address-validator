<?php

use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Strategies\Denmark\DenmarkStrategy;
use Illuminate\Support\Collection;

test('Denmark washing - checking object', function () {

    $address = new AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark = new DenmarkStrategy();

    $response_type = gettype($denmark->wash($address));

    expect($response_type)->toEqual('object');

});

test('Denmark washing - check if applying washing rules', function () {

    $address = new AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark = new DenmarkStrategy();

    $response_array = $denmark->wash($address)->toArray();
    $response_array_count = count($response_array);

    expect($response_array_count)->toEqual(0 < $response_array_count);

});

