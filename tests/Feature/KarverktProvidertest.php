<?php

use App\Integrations\Kartverket\KartverketProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;

test('test should return exact match', function () {
    // Arrange
    $provider = new KartverketProvider();

    $address = new AddressRequest([
        'street'       => 'Kampengata 18',
        'zip_code'     => '0654',
        'city'         => '',
        'country_code' => 'NO'
    ]);

    $kartverkt_response_data = [
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

    $url = KartverketProvider::WASH_ENDPOINT . '?' . KartverketProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(KartverketProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $kartverkt_response_data['street_name'],
                        "adresseringsvejnavn" => $kartverkt_response_data['street_name'],
                        "husnr"               => $kartverkt_response_data['street_number'],
                        "postnr"              => $kartverkt_response_data['zip_code'],
                        "postnrnavn"          => $kartverkt_response_data['city'],
                        "adgangsadresseid"    => $kartverkt_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $kartverkt_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $kartverkt_response_data['id'] => Http::response([
            "adressebetegnelse" => $kartverkt_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $kartverkt_response_data['street_name']
                ],
                "husnr"      => $kartverkt_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $kartverkt_response_data['zip_code'],
                    "navn" => $kartverkt_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $kartverkt_response_data['longitude'],
                        1 => $kartverkt_response_data['latitude']
                    ]
                ],
                "brofast"    => $kartverkt_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([]));

    // Assert
    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([
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
    $provider = new KartverketProvider();

    $address = new AddressRequest([
        'street'       => 'Allevej 57',
        'zip_code'     => '2635',
        'country_code' => 'DK'
    ]);

    $kartverket_response_data = [
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

    $url = KartverketProvider::WASH_ENDPOINT . '?' . KartverketProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(KartverketProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "kategori"   => $kartverket_response_data['confidence'],
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $kartverket_response_data['street_name'],
                        "adresseringsvejnavn" => $kartverket_response_data['street_name'],
                        "husnr"               => $kartverket_response_data['street_number'],
                        "postnr"              => $kartverket_response_data['zip_code'],
                        "postnrnavn"          => $kartverket_response_data['city'],
                        "adgangsadresseid"    => $kartverket_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $kartverket_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $kartverket_response_data['id'] => Http::response([
            "adressebetegnelse" => $kartverket_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $kartverket_response_data['street_name']
                ],
                "husnr"      => $kartverket_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $kartverket_response_data['zip_code'],
                    "navn" => $kartverket_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $kartverket_response_data['longitude'],
                        1 => $kartverket_response_data['latitude']
                    ]
                ],
                "brofast"    => $kartverket_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([$address]));

    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response)->toMatchArray([
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

    $provider = new KartverketProvider();

    $address = new AddressRequest([
        'street'       => 'Allévej 570',
        'zip_code'     => '2635',
        'country_code' => 'DK'
    ]);

    $kartverket_response_data = [
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

    $url = KartverketProvider::WASH_ENDPOINT . '?' . KartverketProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(KartverketProvider::format_address_attributes($address));
    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "kategori"   => $kartverket_response_data['confidence'],
            "resultater" => [
                0 => [
                    "aktueladresse" => [
                        "vejnavn"             => $kartverket_response_data['street_name'],
                        "adresseringsvejnavn" => $kartverket_response_data['street_name'],
                        "husnr"               => $kartverket_response_data['street_number'],
                        "postnr"              => $kartverket_response_data['zip_code'],
                        "postnrnavn"          => $kartverket_response_data['city'],
                        "adgangsadresseid"    => $kartverket_response_data['id'],
                        "href"                => "https://api.dataforsyningen.dk/adresser/" . $kartverket_response_data['id']
                    ]
                ]
            ]
        ], 200),
    ]);
    /* Faked id lookup */
    Http::fake([
        'https://api.dataforsyningen.dk/adresser/' . $kartverket_response_data['id'] => Http::response([
            "adressebetegnelse" => $kartverket_response_data['address_formatted'],
            "adgangsadresse"    => [
                "vejstykke"  => [
                    "navn" => $kartverket_response_data['street_name']
                ],
                "husnr"      => $kartverket_response_data['street_number'],
                "postnummer" => [
                    "nr"   => $kartverket_response_data['zip_code'],
                    "navn" => $kartverket_response_data['city']
                ],
                "vejpunkt"   => [
                    "koordinater" => [
                        0 => $kartverket_response_data['longitude'],
                        1 => $kartverket_response_data['latitude']
                    ]
                ],
                "brofast"    => $kartverket_response_data['mainland']
            ]
        ], 200)
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([$address]));

    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([
        'address_formatted' => "Allevej 57, 2635 Ishøj",
        'street_name'       => "c",
        'street_number'     => "57",
        'zip_code'          => "2635",
        'city'              => "Ishøj",
        'longitude'         => 12.25640294,
        'latitude'          => 55.62299142,
    ]);
});


