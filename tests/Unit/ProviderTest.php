<?php

test('test attributes', function () {
    // Arrange
    $attr = [
        'street' => 'urbansgade 23',
        'state' => '',
        'zip_code'=>'9000',
        'city'=>'Aalborg',
        'country_code' => 'DK'
    ];
    $address = new \App\Models\AddressRequest($attr);

    // Act
    $address_attributes = \App\Integrations\Dawa\DawaProvider::get_attributes($address);

    // Assert
    expect($address_attributes)->toEqual('urbansgade 23, 9000 Aalborg');
});
