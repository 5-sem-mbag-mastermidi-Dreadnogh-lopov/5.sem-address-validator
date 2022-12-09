<?php

use App\Integrations\Confidence;
use App\Integrations\Google\GoogleMapsProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
$providers = array_values(
    array_filter(
        get_declared_classes(),
        function ($className) {
            return is_subclass_of($className, BaseProvider::class);
        }
    )
); // TODO make generic tests for all providers for common functionality and results
$provider = getProvider($providers[0]);
*/

class GoogleMapsProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_return_exact_match()
    {
        // Arrange
        Http::preventStrayRequests();

        $provider = new GoogleMapsProvider();

        $address = new AddressRequest([
            'street'       => 'Kollegievej 2B, 3. 9',
            'zip_code'     => '9000',
            'city'         => 'Aalborg',
            'country_code' => 'DK'
        ]);

        $dawa_response_data = [
            'id'                => "6a9d33c6-c93f-419e-b030-b8de53eaa7c0",
            'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg, Danmark",
            'street_name'       => "Kollegievej",
            'street_number'     => "2B",
            'subpremise'        => "3. 9",
            'zip_code'          => "9000",
            'country_code'      => "DK",
            'country'           => "Danmark",
            'city'              => "Aalborg",
            'longitude'         => 9.9437139,
            'latitude'          => 57.0247396,
        ];

        $url = GoogleMapsProvider::ENDPOINT . '*';
        /* Faked data wash */
        Http::fake([
            $url => Http::response([
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
                                    "text" => $dawa_response_data['subpremise'],
                                ],
                                "componentType"     => "subpremise",
                                "confirmationLevel" => "UNCONFIRMED_BUT_PLAUSIBLE"
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
                "responseId" => $dawa_response_data['id'],
            ], 200),
        ]);

        // Act
        $response = $provider->validateAddress($address, collect([$address]));

        // Assert
        expect($response)->toBeInstanceOf(AddressResponse::class);
        expect($response->attributesToArray())->toMatchArray([
            'confidence'        => Confidence::Sure,
            'address_formatted' => "Kollegievej 2B, 3. 9, 9000 Aalborg, Danmark",
            'street_name'       => "Kollegievej",
            'street_number'     => "2B, 3. 9",
            'zip_code'          => "9000",
            'city'              => "Aalborg",
            'longitude'         => 9.9437139,
            'latitude'          => 57.0247396,
        ]);
    }
}
