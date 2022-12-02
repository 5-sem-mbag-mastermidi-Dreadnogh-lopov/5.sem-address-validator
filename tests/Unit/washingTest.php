<?php

use App\Models\AddressRequest;
use App\Strategies\Denmark\DenmarkStrategy;

test('Denmark washing - checking object', function () {
    $address = new AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark = new DenmarkStrategy();

    $response = $denmark->wash($address)->toArray();

    expect([$response])->toBeArray()->not->toBeEmpty();
});

test('Denmark washing - Checking validating method', function () {
    $address = new AddressRequest([
        'street' => 'Borg vej  xiiis, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    $denmark = new DenmarkStrategy();

    $response = $denmark->wash($address)->toArray();

    expect($response)->toHaveKey('0.state', null);
    expect($response)->toHaveKey('0.city', 'Aalborg');
    expect($response)->toHaveKey('0.street', 'Borg vej  xiiis, 1 tv');
    expect($response)->toHaveKey('0.zip_code', '9000');
    expect($response)->toHaveKey('0.country_code', 'DK');

    expect($response)->toHaveKey('58.state', null);
    expect($response)->toHaveKey('58.city', 'Aalborg');
    expect($response)->toHaveKey('58.street', 'BORGMESTER vej  xiiis, 1 tv');
    expect($response)->toHaveKey('58.zip_code', '9000');
    expect($response)->toHaveKey('58.country_code', 'DK');
});
