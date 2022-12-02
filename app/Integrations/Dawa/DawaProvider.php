<?php

namespace App\Integrations\Dawa;

use App\Integrations\BaseProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DawaProvider extends BaseProvider
{
    public const WASH_ENDPOINT = 'https://api.dataforsyningen.dk/datavask/adresser';
    public const WASH_ENDPOINT_PARAMS = ['betegnelse'];

    public function validateAddress(AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
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
            'street_number' => self::format_street_number($response->json()),
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
    protected function searchForMathces(AddressRequest $address, Collection|AddressRequest $wash_results): Response
    {
        // Attempt to use the original address submitted
        $wash_response = Http::get($this::WASH_ENDPOINT, [
            'betegnelse' => $this::format_address_attributes($address)
        ]);

        // if not an exact match is found, attempt to use the different variations
        $responses = [$wash_response];
        if ($wash_response['kategori'] != 'A') {
            $responses += Http::pool(function (Pool $pool) use ($wash_results, $address) {
                foreach ($wash_results as $wash_result) {
                    $pool->get($this::WASH_ENDPOINT, [
                        'betegnelse' => $this::format_address_attributes($wash_result)
                    ]);
                }
            });
        }

        // TODO: it should choose the best one here and return that one
        usort($responses, function ($a, $b) {
            return strcmp($a['kategori'], $b['kategori']);
        });

        return $responses[0];
    }

    protected function getExactAddress(Response $response): Response
    {
        // Always takes the first address suggestion from the datawash result
        return Http::get($response['resultater'][0]['aktueladresse']['href']);
    }

    public static function format_address_attributes(AddressRequest $address): string
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }

    protected static function convert_confidence(mixed $determinant): string
    {
        return match ($determinant) {
            'A' => 'exact',
            'B' => 'sure',
            'C' => 'unsure',
            default => 'unknown'
        };
    }

    protected static function format_street_number(mixed $input): string
    {
        if (!array_key_exists('adgangsadresse', $input) && array_key_exists('husnr', $input['adgangsadresse'])) {
            throw new \Exception("no arguments given for street number");
        }

        $formatted = $input['adgangsadresse']['husnr'];
        if (isset($input['etage'])) {
            $formatted .= " {$input['etage']}.";
        }

        if (isset($input['dør'])) {
            $formatted .= " {$input['dør']}";
        }

        return $formatted;
    }
}
