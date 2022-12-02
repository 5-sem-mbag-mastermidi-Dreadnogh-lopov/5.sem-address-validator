<?php

namespace Tests\Feature;

use App\Integrations\Dawa\DawaProvider;
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
        $uri = '/api/v1/login?password=test';
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(401);
    }

    public function test_the_application_returns_a_successful_response_to_api_v1_login()
    {
        //arrange
        $uri = '/api/v1/login?password=' . env('APP_PASSWORD');
        //act
        $response = $this->get($uri);
        //assert
        $response->assertStatus(200);
    }

    public function test_should_return_address_from_response()
    {
        // Arrange
        $address = new AddressRequest([
            "street" => "Kollegievej 2B",
            "zip_code" => "9000",
            "city" => "Aalborg",
            "country_code" => "DK",
        ]);

        $dawa_response_data = [
            'id' => "1b22bd91-adde-41fd-93de-fe5037cbf02d",
            'confidence' => 'A',
            'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg",
            'street_name' => "Kollegievej",
            'street_number' => "2B",
            'zip_code' => "9000",
            'city' => "Aalborg",
            'longitude' => 9.94332025,
            'latitude' => 57.02471574,
            'mainland' => true,
        ];

        $url = url(DawaProvider::WASH_ENDPOINT . '?' . http_build_query([
                DawaProvider::WASH_ENDPOINT_PARAMS[0] => urlencode(DawaProvider::format_address_attributes($address))
            ])
        );

        /* Faked data wash */
        Http::fake([
            $url => Http::response([
                "kategori" => $dawa_response_data['confidence'],
                "resultater" => [
                    0 => [
                        "aktueladresse" => [
                            "vejnavn" => $dawa_response_data['street_name'],
                            "adresseringsvejnavn" => $dawa_response_data['street_name'],
                            "husnr" => $dawa_response_data['street_number'],
                            "postnr" => $dawa_response_data['zip_code'],
                            "postnrnavn" => $dawa_response_data['city'],
                            "adgangsadresseid" => $dawa_response_data['id'],
                            "href" => "https://api.dataforsyningen.dk/adresser/" . $dawa_response_data['id']
                        ]
                    ]
                ]
            ], 200),
        ]);
        /* Faked id lookup */
        Http::fake([
            'https://api.dataforsyningen.dk/adresser/' . $dawa_response_data['id'] => Http::response([
                "adressebetegnelse" => $dawa_response_data['address_formatted'],
                "adgangsadresse" => [
                    "vejstykke" => [
                        "navn" => $dawa_response_data['street_name']
                    ],
                    "husnr" => $dawa_response_data['street_number'],
                    "postnummer" => [
                        "nr" => $dawa_response_data['zip_code'],
                        "navn" => $dawa_response_data['city']
                    ],
                    "vejpunkt" => [
                        "koordinater" => [
                            0 => $dawa_response_data['longitude'],
                            1 => $dawa_response_data['latitude']
                        ]
                    ],
                    "brofast" => $dawa_response_data['mainland']
                ]
            ], 200)
        ]);

        // Act
        $response = $this->get(
            url('api/v1/datawash?' . http_build_query($address->attributesToArray()))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        // Assert
        expect($response->status())->toBe(200);
    }

    public function test_should_return_address_from_cache()
    {
        // Arrange
        Http::preventStrayRequests();
        $this->seed();

        $address = new AddressRequest([
            "street" => "Fyrkildevej 104, 1. tv",
            "zip_code" => "9220",
            "city" => "Aalborg",
            "country_code" => "DK",
        ]);

        // Act
        $response = $this->get(
            url('api/v1/datawash?' . http_build_query($address->attributesToArray()))
        )->withHeaders([
            "Accept" => "application/json"
        ]);

        // Assert
        expect($response->status())->toBe(200);
        expect($response->getData())->toHaveKey('address_formatted', 'Fyrkildevej 104, 1. tv, 9220 Aalborg');
    }
}
