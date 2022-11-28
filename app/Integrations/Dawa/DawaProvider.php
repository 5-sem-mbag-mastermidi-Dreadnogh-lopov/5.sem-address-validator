<?php

namespace App\Integrations\Dawa;

use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class DawaProvider implements Provider
{
    protected string $base_url = 'https://api.dataforsyningen.dk/';

    function validateAddress(AddressRequest $address, array|AddressRequest $wash_results): AddressResponse
    {
        $initial_search = $this->searchForMathces($address, $wash_results);

        $response = $this->getExactAddress($initial_search);

        $extra = [
            'confidence' => $initial_search['kategori']
        ];
        $address = $this->addressFromResponse($response, $extra);

        return $address;
    }

    protected function addressFromResponse(Response $response, array $extra = null): AddressResponse
    {
        return new AddressResponse([
            'confidence' => self::convert_confidence($extra['confidence']),
            'address_formatted' => $response['adressebetegnelse'],
            'street_name' => $response['adgangsadresse']['vejstykke']['navn'],
            'street_number' => $response['adgangsadresse']['husnr'] . ', ' . $response['etage'] . '. ' . $response['dør'],
            'zip_code' => $response['adgangsadresse']['postnummer']['nr'],
            'city' => $response['adgangsadresse']['postnummer']['navn'],
            'state' => '',
            'country_code' => 'DK',
            'country_name' => 'Denmark',
            'longitude' => $response['adgangsadresse']['vejpunkt']['koordinater'][0],
            'latitude' => $response['adgangsadresse']['vejpunkt']['koordinater'][1],
            'mainland' => $response['adgangsadresse']['brofast'],
            'response_json' => json_encode($response->json()),
        ]);
    }

    /**
     * @param AddressRequest $address
     * @param array|AddressRequest $wash_results
     * @return Response
     */
    public function searchForMathces(AddressRequest $address, array|AddressRequest $wash_results): Response
    {
        // Attempt to use the original address submitted
        $wash_response = Http::get($this->base_url . 'datavask/adresser', [
            'betegnelse' => $this->get_attributes($address)
        ]);

        // if not an exact match is found, attempt to use the different variations
        $responses = [$wash_response];
        if ($wash_response['kategori'] != 'A') {
            $responses[] = Http::pool(function (Pool $pool) use ($wash_results, $address) {
                foreach ($wash_results as $wash_result) {
                    $pool->get($this->base_url . 'datavask/adresser', [
                        'betegnelse' => $this->get_attributes($wash_result)
                    ]);
                }
            });
        }

        /* TODO: it should choose the best one here and return that one
        $obj = array_reduce($responses, static function ($carry, $item) {
            return $carry === false && $item['resultater'][0]['aktueladresse']['href'] != '' ? $item : $carry;
        }, false);
        */

        return $responses[0];
    }

    protected function getExactAddress(Response $response): Response
    {
        // Always takes the first address suggestion from the datawash result
        return Http::get($response['resultater'][0]['aktueladresse']['href']);
    }

    public static function get_attributes(AddressRequest $address)
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }

    private static function convert_confidence(string $confidence): string
    {
        return match ($confidence) {
            'A' => 'exact',
            'B' => 'sure',
            'C' => 'unsure',
            default => 'unknown'
        };
    }
}
