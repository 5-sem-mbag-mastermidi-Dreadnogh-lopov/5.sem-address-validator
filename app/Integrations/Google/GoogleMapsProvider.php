<?php

namespace App\Integrations\Google;

use App\Integrations\BaseProvider;
use App\Integrations\Confidence;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GoogleMapsProvider extends BaseProvider
{
    public const ENDPOINT = 'https://addressvalidation.googleapis.com/v1:validateAddress?key=';

    function validateAddress(AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
    {
        $response = $this->searchForMathces($address, $wash_results);


        $address = $this->addressFromResponse($response);

        return $address;
    }

    protected static function convert_confidence(mixed $determinant): Confidence
    {
        $verdict = Confidence::Unknown;

        if (!isset($determinant['result']['verdict']['hasInferredComponents'])
            && !isset($determinant['result']['verdict']['hasUnconfirmedComponents'])
            && !isset($determinant['result']['verdict']['hasReplacedComponents'])
            && isset($determinant['result']['verdict']['addressComplete'])){
            $verdict = Confidence::Exact;
        } elseif (self::get_component_text($determinant, 'confirmationLevel', 'UNCONFIRMED_AND_SUSPICIOUS') != null
            || !isset($determinant['result']['verdict']['addressComplete'])) {
            $verdict = Confidence::Unsure;
        } else {
            $verdict = Confidence::Sure;
        }

        return $verdict;
    }

    protected function addressFromResponse(Response $response, array $extra = null): AddressResponse
    {
        return new AddressResponse([
            'confidence'        => self::convert_confidence($response),
            'address_formatted' => $response['result']['address']['formattedAddress'] ?? null,
            'street_name'       => self::get_component_text($response, 'componentType','route') ?? null,
            'street_number'     => self::format_street_number($response),
            'zip_code'          => $response['result']['address']['postalAddress']['postalCode'] ?? null,
            'city'              => $response['result']['address']['postalAddress']['locality'] ?? null,
            'state'             => $response['result']['address']['postalAddress']['administrativeArea'] ?? null,
            'country_code'      => $response['result']['address']['postalAddress']['regionCode'] ?? null,
            'country_name'      => self::get_component_text($response, 'componentType','country'),
            'longitude'         => $response['result']['geocode']['location']['longitude'] ?? null,
            'latitude'          => $response['result']['geocode']['location']['latitude'] ?? null,
            'response_json'     => json_encode($response->json()),
        ]);
    }

    protected function searchForMathces(AddressRequest $address, Collection|AddressRequest $wash_results): Response
    {
        // Attempt to use the original address submitted
        $wash_response = Http::post($this::ENDPOINT . env('GOOGLE_API_KEY'), self::format_request_to_body($address));

        // if not an exact match is found, attempt to use the different variations
        $responses = [$wash_response];
        if (isset($wash_response['result']['verdict']['hasInferredComponents'])
            || isset($wash_response['result']['verdict']['hasUnconfirmedComponents'])
            || isset($wash_response['result']['verdict']['hasReplacedComponents'])) {
            $responses += Http::pool(function (Pool $pool) use ($wash_results) {
                foreach ($wash_results as $wash_result) {
                    $pool->post($this::ENDPOINT . env('GOOGLE_API_KEY'), self::format_request_to_body($wash_result));
                }
            });
        }

        // TODO: it should choose the best one here and return that one

        return $responses[0];
    }

    protected static function format_street_number(Response $response): string
    {
        $street_number = self::get_component_text($response,'componentType','street_number'); // TODO same problem as subpremise, just returns the input without formatting

        $subpremise = self::get_component_text($response,'componentType','subpremise'); // TODO google doesnt format for you, so if your input is 'urbansgade 23 1 tv' you'll get '1 tv' and not '1. tv' as if formatted (like Dawa does)
        if (isset($subpremise)) {
            $street_number .= ', ' . $subpremise;
        }

        return $street_number;
    }

    protected static function get_component_text(Response $response, string $component_columnn, string $value)
    {
        $components = $response['result']['address']['addressComponents'];
        $component_types = array_column($components, $component_columnn);

        $search_res = array_search($value, $component_types);
        if ($search_res !== false) {
            $res = $components[$search_res]['componentName']['text'];
        }

        return $res ?? null;
    }

    protected static function format_request_to_body(AddressRequest $address): array
    {
        return [
            'address' => [
                "regionCode"   => $address['country_code'],
                "postal_code"  => $address['zip_code'],
                "locality"     => $address['city'],
                "addressLines" => [
                    $address['street']
                ]
            ]
        ];
    }
}
