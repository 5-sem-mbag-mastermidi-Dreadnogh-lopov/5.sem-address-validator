<?php

use App\Integrations\Kartverket\KartverketProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Facades\Http;

test('test should return exact match', function () {
    // Arrange
    Http::preventStrayRequests();
    $provider = new KartverketProvider();

    $address = new AddressRequest([
        'street'       => 'Kampengata 18A',
        'zip_code'     => '0654',
        'city'         => 'OSLO',
        'country_code' => 'NO'
    ]);

    $kartverkt_response_data = [
        'street_name'   => "Kampengata",
        'street_number' => "18A",
        'zip_code'      => "0654",
        'city'          => "OSLO",
        'nummer'        => "18",
        'bokstav'       => "A",
        'longitude'     => 10.780512503077,
        'latitude'      => 59.912643213965,
    ];
    $parameters = http_build_query([
        "sok"         => $address->street ?? null,
        "kommunenavn" => $address->state ?? null,
        "postnummer"  => $address->zip_code ?? null,
        "poststed"    => $address->city ?? null
    ]);

    $url = KartverketProvider::WASH_ENDPOINT . $parameters;

    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "metadata" => [
                "sokeStreng"        => "fuzzy=true&sok=Kampengata+18A&postnummer=0654&poststed=OSLO",
                "viserTil"          => 10,
                "side"              => 0,
                "asciiKompatibel"   => true,
                "viserFra"          => 0,
                "treffPerSide"      => 10,
                "totaltAntallTreff" => 1
            ],
            "adresser" => [
                0 => [
                    "adressenavn"          => $kartverkt_response_data['street_name'],
                    "adressetekst"         => $kartverkt_response_data['street_name'] . " " . $kartverkt_response_data['street_number'],
                    "poststed"             => $kartverkt_response_data['city'],
                    "nummer"               => $kartverkt_response_data['nummer'],
                    "bokstav"              => $kartverkt_response_data['bokstav'],
                    "postnummer"           => $kartverkt_response_data['zip_code'],
                    "representasjonspunkt" => [
                        "lat" => $kartverkt_response_data['latitude'],
                        "lon" => $kartverkt_response_data['longitude'],
                    ]
                ],
            ],
        ])
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([]));

    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([
        'street_name'       => "Kampengata",
        'address_formatted' => "Kampengata 18A, 0654 OSLO, Norge",
        'zip_code'          => "0654",
        'city'              => "OSLO",
        'longitude'         => 10.780512503077,
        'latitude'          => 59.912643213965,
    ]);
});


test('test should return unknown match', function () {
    // Arrange
    Http::preventStrayRequests();
    Http::clearResolvedInstances();

    $provider = new KartverketProvider();

    $address = new AddressRequest([
        'street'       => 'Kampengata 18A',
        'zip_code'     => '0654',
        'country_code' => 'NO'
    ]);

    $kartverkt_response_data = [];

    $parameters = http_build_query([
        "sok"        => $address->street ?? null,
        "postnummer" => $address->zip_code ?? null,
    ]);

    $url = KartverketProvider::WASH_ENDPOINT . $parameters;

    /* Faked data wash */
    Http::fake([
        $url => Http::response([
            "adresser" => [],
        ])
    ]);

    // Act
    $response = $provider->validateAddress($address, collect([]));

    // Assert
    // Assert
    expect($response)->toBeInstanceOf(AddressResponse::class);
    expect($response->attributesToArray())->toMatchArray([]);
});

