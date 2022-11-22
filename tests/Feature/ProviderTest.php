<?php

test('test ValidateAddress', function () {
    $address = new \App\Models\AddressRequest([
        'street' => 'urbansgade 23, 1 tv',
        'zip_code' => '9000',
        'city' => 'Aalborg',
        'country_code' => 'DK'
    ]);

    Http::fake([
        'https://api.dataforsyningen.dk/datavask/adresser?betegnelse=*' => Http::response([
            "kategori" => "A",
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn" => "Urbansgade",
                        "adresseringsvejnavn" => "Urbansgade",
                        "husnr" => "23",
                        "supplerendebynavn" => null,
                        "postnr" => "9000",
                        "postnrnavn" => "Aalborg",
                        "status" => 1,
                        "virkningstart" => "2009-11-24T02:15:25.000Z",
                        "virkningslut" => null,
                        "adgangsadresseid" => "0a3f509c-d8bb-32b8-e044-0003ba298018",
                        "etage" => "1",
                        "dør" => "tv",
                        "href" => "https://api.dataforsyningen.dk/adresser/0a3f50ca-e927-32b8-e044-0003ba298018"
                    ]
                ]
            ]
        ], 200),
    ]);

    $provider = new \App\Integrations\Dawa\DawaProvider();

    $response = $provider->ValidateAddress($address, []);

    expect($response->city)->toEqual('Aalborg');
});
