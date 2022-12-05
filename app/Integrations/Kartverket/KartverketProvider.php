<?php

namespace App\Integrations\Kartverket;

use App\Integrations\BaseProvider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class KartverketProvider extends BaseProvider
{
    public const WASH_ENDPOINT = 'https://ws.geonorge.no/adresser/v1/sok?fuzzy=true&';
    public const WASH_ENDPOINT_PARAMS = ['betegnelse'];

    public function validateAddress(AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
    {

        $initial_search = $this->searchForMathces($address, $wash_results);

        $address = $this->addressFromResponse($initial_search);

        return $address;
    }

    protected function addressFromResponse(Response $response, array $extra = null): AddressResponse
    {

        return new AddressResponse([
            'confidence' => "",
            'address_formatted' => $response['adresser'][0]['adressenavn'] . $response['adresser'][0]['nummer'] . $response['adresser'][0]['postnummer'] . $response['adresser'][0]['poststed'] . "Norge",
            'street_name' => $response['adresser'][0]['adressenavn'],
            'street_number' => $response['adresser'][0]['nummer'],
            'zip_code' => $response['adresser'][0]['postnummer'],
            'city' => $response['adresser'][0]['poststed'],
            'state' =>  $response['adresser'][0]['kommunenavn'],
            'country_code' => 'NO',
            'country_name' => 'Norge',
            'longitude' => $response['adresser'][0]['representasjonspunkt']['lon'],
            'latitude' => $response['adresser'][0]['representasjonspunkt']['lat'],
            'mainland' => null,
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

        $parameters = http_build_query([
            "adressetekst" => $address->street ?? null,
            "kommunenavn" => $address->state ?? null,
            "kommunenummer" => $address->zip_code ?? null,
            "poststed" => $address->city ?? null
        ]);

        $wash_response = Http::get($this::WASH_ENDPOINT . $parameters);

        $responses = [$wash_response];

        if ($wash_response["adresser"]) {
            $responses += Http::pool(function (Pool $pool) use ($wash_results) {
                foreach ($wash_results as $wash_result) {
                    $pool->get($this::format_address_attributes($wash_result));
                }
            });
        }

        return $responses[0];
    }


}
