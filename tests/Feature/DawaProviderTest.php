<?php

use App\Integrations\Confidence;
use App\Integrations\Dawa\DawaProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Facades\Http;

test('test should return exact match', function () {
    // Arrange
    $provider = new DawaProvider();

    $address = new AddressRequest([
        'street'       => 'Kollegievej 2B, 3. 9',
        'zip_code'     => '9000',
        'city'         => 'Aalborg',
        'country_code' => 'DK'
    ]);


    $dawa_response_data = [
        'id'                => "1b22bd91-adde-41fd-93de-fe5037cbf02d",
        'confidence'        => 'A',
        'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg",
        'street_name'       => "Kollegievej",
        'street_number'     => "2B",
        'zip_code'          => "9000",
        'city'              => "Aalborg",
        'longitude'         => 9.94332025,
        'latitude'          => 57.02471574,
        'mainland'          => true,
    ];

    $url = DawaProvider::WASH_ENDPOINT . '?' . DawaProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(DawaProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "kategori"   => $dawa_response_data['confidence'],
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $dawa_response_data['street_name'],
                        "adresseringsvejnavn" => $dawa_response_data['street_name'],
                        "husnr"               => $dawa_response_data['street_number'],
                        "postnr"              => $dawa_response_data['zip_code'],
                        "postnrnavn"          => $dawa_response_data['city'],
                        "adgangsadresseid"    => $dawa_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $dawa_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $dawa_response_data['id'] => Http::response([
            "adressebetegnelse" => $dawa_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $dawa_response_data['street_name']
                ],
                "husnr"      => $dawa_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $dawa_response_data['zip_code'],
                    "navn" => $dawa_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $dawa_response_data['longitude'],
                        1 => $dawa_response_data['latitude']
                    ]
                ],
                "brofast"    => $dawa_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([]));

    // Assert
    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([
        'confidence'        => Confidence::Exact,
        'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg",
        'street_name'       => "Kollegievej",
        'street_number'     => "2B",
        'zip_code'          => "9000",
        'city'              => "Aalborg",
        'longitude'         => 9.94332025,
        'latitude'          => 57.02471574,
        'mainland'          => true,
    ]);
});

test('test should return sure match', function () {
    // Arrange
    $provider = new DawaProvider();

    $address = new AddressRequest([
        'street'       => 'Allevej 57',
        'zip_code'     => '2635',
        'country_code' => 'DK'
    ]);

    $dawa_response_data = [
        'id'                => "0a3f50a7-04ee-32b8-e044-0003ba298018",
        'confidence'        => 'B',
        'address_formatted' => "Allevej 57, 2635 Ishøj",
        'street_name'       => "Allevej",
        'street_number'     => "57",
        'zip_code'          => "2635",
        'city'              => "Ishøj",
        'longitude'         => 12.25640294,
        'latitude'          => 55.62299142,
        'mainland'          => true,
    ];

    $url = DawaProvider::WASH_ENDPOINT . '?' . DawaProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(DawaProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "kategori"   => $dawa_response_data['confidence'],
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $dawa_response_data['street_name'],
                        "adresseringsvejnavn" => $dawa_response_data['street_name'],
                        "husnr"               => $dawa_response_data['street_number'],
                        "postnr"              => $dawa_response_data['zip_code'],
                        "postnrnavn"          => $dawa_response_data['city'],
                        "adgangsadresseid"    => $dawa_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $dawa_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $dawa_response_data['id'] => Http::response([
            "adressebetegnelse" => $dawa_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $dawa_response_data['street_name']
                ],
                "husnr"      => $dawa_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $dawa_response_data['zip_code'],
                    "navn" => $dawa_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $dawa_response_data['longitude'],
                        1 => $dawa_response_data['latitude']
                    ]
                ],
                "brofast"    => $dawa_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([$address]));

    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response)->toMatchArray([
        'confidence'        => Confidence::Sure,
        'address_formatted' => "Allevej 57, 2635 Ishøj",
        'street_name'       => "Allevej",
        'street_number'     => "57",
        'zip_code'          => "2635",
        'city'              => "Ishøj",
        'longitude'         => 12.25640294,
        'latitude'          => 55.62299142,
        'mainland'          => true,
    ]);
});

test('test should return unsure match', function () {
    // Arrange
    Http::preventStrayRequests();
    Http::clearResolvedInstances();

    $provider = new DawaProvider();

    $address = new AddressRequest([
        'street'       => 'Allévej 570',
        'zip_code'     => '2635',
        'country_code' => 'DK'
    ]);

    $dawa_response_data = [
        'id'                => "0a3f50a7-04ee-32b8-e044-0003ba298018",
        'confidence'        => 'C',
        'address_formatted' => "Allevej 57, 2635 Ishøj",
        'street_name'       => "Allevej",
        'street_number'     => "57",
        'zip_code'          => "2635",
        'city'              => "Ishøj",
        'longitude'         => 12.25640294,
        'latitude'          => 55.62299142,
        'mainland'          => true,
    ];

    $url = DawaProvider::WASH_ENDPOINT . '?' . DawaProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(DawaProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "kategori"   => $dawa_response_data['confidence'],
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $dawa_response_data['street_name'],
                        "adresseringsvejnavn" => $dawa_response_data['street_name'],
                        "husnr"               => $dawa_response_data['street_number'],
                        "postnr"              => $dawa_response_data['zip_code'],
                        "postnrnavn"          => $dawa_response_data['city'],
                        "adgangsadresseid"    => $dawa_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $dawa_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $dawa_response_data['id'] => Http::response([
            "adressebetegnelse" => $dawa_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $dawa_response_data['street_name']
                ],
                "husnr"      => $dawa_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $dawa_response_data['zip_code'],
                    "navn" => $dawa_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $dawa_response_data['longitude'],
                        1 => $dawa_response_data['latitude']
                    ]
                ],
                "brofast"    => $dawa_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([$address]));

    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([
        'confidence'        => Confidence::Unsure,
        'address_formatted' => "Allevej 57, 2635 Ishøj",
        'street_name'       => "Allevej",
        'street_number'     => "57",
        'zip_code'          => "2635",
        'city'              => "Ishøj",
        'longitude'         => 12.25640294,
        'latitude'          => 55.62299142,
        'mainland'          => true,
    ]);
});


