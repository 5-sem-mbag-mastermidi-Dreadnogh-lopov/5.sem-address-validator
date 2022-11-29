<?php

use App\Integrations\Dawa\DawaProvider;
use App\Models\AddressRequest;

test('test attributes', function () {
    // Arrange
    $address = new AddressRequest([
        'street' => 'urbansgade 23',
        'state' => '',
        'zip_code'=>'9000',
        'city'=>'Aalborg',
        'country_code' => 'DK'
    ]);
    // Act
    $address_attributes = DawaProvider::get_attributes($address);

    // Assert
    expect($address_attributes)->toEqual('urbansgade 23, 9000 Aalborg');
});
