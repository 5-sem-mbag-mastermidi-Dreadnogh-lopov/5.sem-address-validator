<?php

test('test ValidateAddress', function () {
    $address = new \App\Models\AddressRequest([
        'street' => 'urbansgade 23',
        'state' => '',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    Http::fake([
        'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=*' => Http::response([
            'kategori' => "A",
            'resultater' => [
                '0' => [
                    'aktueladresse' => [
                        'id' => '77edff31-1517-49ce-93d5-dfe02cc60dab',
                        'vejnavn' => 'Urbansgade'
                    ]
                ]
            ]
        ], 200),
    ]);

    $provider = new \App\Integrations\Dawa\DawaProvider();

    $response = $provider->ValidateAddress($address, []);

    expect($response->category)->toEqual('A');
    expect($response->address_id)->toEqual('77edff31-1517-49ce-93d5-dfe02cc60dab');
    expect($response->street)->toEqual('Urbansgade');
});
