<?php

use App\Strategies\Denmark\DenmarkStrategy;

test('Denmarkwashing', function () {

    $address = new \App\Models\AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark_washing = new DenmarkStrategy();

    $response = $denmark_washing->validateAddress($address);

    expect($response->city)->toEqual('Aalborg');
});
