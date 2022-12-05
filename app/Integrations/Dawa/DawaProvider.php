<?php

namespace App\Integrations\Dawa;

use App\Integrations\BaseProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Integrations\Confidence;
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

        if (!isset($response['resultater'][0]['aktueladresse']['href'])) {
            $response = $this->getExactAddress($initial_search);
        }

        $extra = [
            'confidence' => $initial_search['kategori']
        ];
        $address = $this->addressFromResponse($response, $extra);

        return $address;
    }

    protected function addressFromResponse(Response $response, array $extra = null): AddressResponse
    {
        return new AddressResponse([
            'confidence'        => self::convert_confidence($extra['confidence']),
            'address_formatted' => $response['adressebetegnelse'],
            'street_name'       => $response['adgangsadresse']['vejstykke']['navn'],
            'street_number'     => self::format_street_number($response->json()),
            'zip_code'          => $response['adgangsadresse']['postnummer']['nr'],
            'city'              => $response['adgangsadresse']['postnummer']['navn'],
            'state'             => '',
            'country_code'      => 'DK',
            'country_name'      => 'Denmark',
            'longitude'         => $response['adgangsadresse']['vejpunkt']['koordinater'][0],
            'latitude'          => $response['adgangsadresse']['vejpunkt']['koordinater'][1],
            'mainland'          => $response['adgangsadresse']['brofast'],
            'response_json'     => json_encode($response->json()),
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
            $responses += Http::pool(function (Pool $pool) use ($wash_results) {
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

    protected static function convert_confidence(mixed $determinant): Confidence
    {
        return match ($determinant) {
            'A' => Confidence::Exact,
            'B' => Confidence::Sure,
            'C' => Confidence::Unsure,
            default => Confidence::Unknown
        };
    }

    protected static function format_street_number(mixed $response): string
    {
        if (!array_key_exists('adgangsadresse', $response) && array_key_exists('husnr', $response['adgangsadresse'])) {
            throw new \Exception("no arguments given for street number");
        }

        $formatted = $response['adgangsadresse']['husnr'];
        if (isset($response['etage'])) {
            $formatted .= " {$response['etage']}.";
        }

        if (isset($response['dør'])) {
            $formatted .= " {$response['dør']}";
        }

        return $formatted;
    }
}
