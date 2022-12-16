<?php

namespace Tests\Feature;

use App\Integrations\Confidence;
use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Google\GoogleMapsProvider;
use App\Integrations\Kartverket\KartverketProvider;
use App\Models\AddressRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EndPointTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response()
    {
        //arrange
        $uri = "/";
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_to_api_v1_alive()
    {
        //arrange
        $uri = '/api/alive';
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_bad_response_to_api_v1_login()
    {
        //arrange
        $uri = '/api/v1/user?password=test';
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(401);
    }

    public function test_the_application_returns_a_successful_response_to_api_v1_login()
    {
        //arrange
        $uri = '/api/v1/user?password=' . env('APP_PASSWORD');
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(200);
    }

    public function test_should_return_address_from_dk_dawa()
    {
        // Arrange
        Http::preventStrayRequests();
        $this->seed();

        $address = new AddressRequest([
            "street"       => "Kollegievej 2B",
            "zip_code"     => "9000",
            "city"         => "Aalborg",
            "country_code" => "DK",
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

        $url = url(DawaProvider::WASH_ENDPOINT . '?' . DawaProvider::WASH_ENDPOINT_PARAMS[0] . '=' . rawurlencode(DawaProvider::format_address_attributes($address)));
        //dd($url);
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
        $response = $this->post(
            url('api/v1/address?' . http_build_query($address->attributesToArray()))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        // Assert
        expect($response->status())->toBe(200);
        $this->assertDatabaseHas('address', [
            'confidence'        => Confidence::Exact->value,
            'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg, Danmark",
            'street_name'       => "Kollegievej",
            'street_number'     => "2B",
            'zip_code'          => "9000",
            'city'              => "Aalborg",
            'longitude'         => 9.94332025,
            'latitude'          => 57.02471574,
            'mainland'          => true,
        ]);
    }

    public function test_should_return_address_from_dk_google_maps()
    {
        // Arrange
        Http::preventStrayRequests();

        $address = new AddressRequest([
            "street"       => "Kollegievej 2B",
            "zip_code"     => "9000",
            "city"         => "Aalborg",
            "country_code" => "DK",
        ]);

        $dawa_response_data = [
            'dawa_id'           => "1b22bd91-adde-41fd-93de-fe5037cbf02d",
            'google_id'         => "6a9d33c6-c93f-419e-b030-b8de53eaa7c0",
            'confidence'        => "B",
            'address_formatted' => "Kollegievej 2B, 9000 Aalborg, Danmark",
            'street_name'       => "Kollegievej",
            'street_number'     => "2B",
            'zip_code'          => "9000",
            'country_code'      => "DK",
            'country'           => "Danmark",
            'city'              => "Aalborg",
            'longitude'         => 9.9437139,
            'latitude'          => 57.0247396,
            'mainland'          => true,
        ];

        $dawa_url = DawaProvider::WASH_ENDPOINT . '*';
        $google_url = GoogleMapsProvider::ENDPOINT . '*';

        /* Faked dawa data wash */
        Http::fake([
            $dawa_url => Http::response([
                "kategori"   => $dawa_response_data['confidence'],
                "resultater" => [
                    0 => [
                        "aktueladresse" => [
                            "vejnavn"             => $dawa_response_data['street_name'],
                            "adresseringsvejnavn" => $dawa_response_data['street_name'],
                            "husnr"               => $dawa_response_data['street_number'],
                            "postnr"              => $dawa_response_data['zip_code'],
                            "postnrnavn"          => $dawa_response_data['city'],
                            "adgangsadresseid"    => $dawa_response_data['dawa_id'],
                            "href"                => "https://api.dataforsyningen.dk/adresser/" . $dawa_response_data['dawa_id']
                        ]
                    ]
                ]
            ], 200),
        ]);
        /* Faked dawa id lookup */
        Http::fake([
            'https://api.dataforsyningen.dk/adresser/' . $dawa_response_data['dawa_id'] => Http::response([
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
        // Faked google maps lookup
        Http::fake([
            $google_url => Http::response([
                "result"     => [
                    "verdict" => [
                        "inputGranularity"         => "SUB_PREMISE",
                        "validationGranularity"    => "PREMISE",
                        "geocodeGranularity"       => "PREMISE",
                        "addressComplete"          => true,
                        "hasUnconfirmedComponents" => true
                    ],
                    "address" => [
                        "formattedAddress"          => $dawa_response_data['address_formatted'],
                        "postalAddress"             => [
                            "regionCode" => $dawa_response_data['country_code'],
                            "postalCode" => $dawa_response_data['zip_code'],
                            "locality"   => $dawa_response_data['city'],

                        ],
                        "addressComponents"         => [
                            [
                                "componentName"     => [
                                    "text" => $dawa_response_data['street_name'],
                                ],
                                "componentType"     => "route",
                                "confirmationLevel" => "CONFIRMED"
                            ],
                            [
                                "componentName"     => [
                                    "text" => $dawa_response_data['street_number'],
                                ],
                                "componentType"     => "street_number",
                                "confirmationLevel" => "CONFIRMED"
                            ],
                            [
                                "componentName"     => [
                                    "text" => $dawa_response_data['zip_code']
                                ],
                                "componentType"     => "postal_code",
                                "confirmationLevel" => "CONFIRMED"
                            ],
                            [
                                "componentName"     => [
                                    "text" => $dawa_response_data['city'],
                                ],
                                "componentType"     => "locality",
                                "confirmationLevel" => "CONFIRMED"
                            ],
                            [
                                "componentName"     => [
                                    "text" => $dawa_response_data['country'],
                                ],
                                "componentType"     => "country",
                                "confirmationLevel" => "CONFIRMED"
                            ]
                        ],
                        "unconfirmedComponentTypes" => [
                            "subpremise"
                        ]
                    ],
                    "geocode" => [
                        "location" => [
                            "latitude"  => $dawa_response_data['latitude'],
                            "longitude" => $dawa_response_data['longitude']
                        ],
                    ]
                ],
                "responseId" => $dawa_response_data['google_id'],
            ], 200),
        ]);

        // Act
        $response = $this->post(
            url('api/v1/address?' . http_build_query($address->attributesToArray(), encoding_type: PHP_QUERY_RFC3986))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        // Assert
        expect($response->status())->toBe(200);
        expect($response->getData())->toMatchArray([
            'confidence'        => 'sure',
            'address_formatted' => "Kollegievej 2B, 9000 Aalborg, Danmark",
            'street_name'       => "Kollegievej",
            'street_number'     => "2B",
            'zip_code'          => "9000",
            'city'              => "Aalborg",
            'longitude'         => 9.9437139,
            'latitude'          => 57.0247396,
        ]);
    }

    public function test_should_return_address_from_cache()
    {
        // Arrange
        Http::preventStrayRequests();
        $this->seed();

        $address = new AddressRequest([
            "street"       => "Fyrkildevej 104, 1. tv",
            "zip_code"     => "9220",
            "city"         => "Aalborg",
            "country_code" => "DK",
        ]);

        // Act
        $response = $this->post(
            url('api/v1/address?' . http_build_query($address->attributesToArray()))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        expect($response->status())->toBe(200);
        expect($response->getData())->toHaveKey('address_formatted', 'Fyrkildevej 104, 1. tv, 9220 Aalborg, Danmark');
    }


    public function test_should_return_address_from_no_karverkt()
    {
        // Arrange
        Http::preventStrayRequests();
        $this->seed();

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
        $response = $this->post(
            url('api/v1/address?' . http_build_query($address->attributesToArray()))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        // Assert
        expect($response->status())->toBe(200);
        $this->assertDatabaseHas('address', [
            'street_name'       => "Kampengata",
            'address_formatted' => "Kampengata 18A, 0654 OSLO, Norge",
            'zip_code'          => "0654",
            'city'              => "OSLO",
            'longitude'         => 10.780512503077,
            'latitude'          => 59.912643213965,
        ]);
    }
}
