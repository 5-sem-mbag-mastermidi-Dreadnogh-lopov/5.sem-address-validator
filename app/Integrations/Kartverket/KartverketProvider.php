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

        if(isset($initial_search['adresser'][0])){
            return $this->addressFromResponse($initial_search);
         }

        return $this->emptyAddressFromResponse();
    }

    protected function addressFromResponse(Response $response, array $extra = null): AddressResponse
    {

        return new AddressResponse([
            'confidence' => "",
            'address_formatted' => $response['adresser'][0]['adressenavn'] . $response['adresser'][0]['nummer'] . $response['adresser'][0]['postnummer'] . $response['adresser'][0]['poststed'] . "Norge" ?? null,
            'street_name' => $response['adresser'][0]['adressenavn'] ?? null,
            'street_number' => $response['adresser'][0]['nummer'] ?? null,
            'zip_code' => $response['adresser'][0]['postnummer'] ?? null,
            'city' => $response['adresser'][0]['poststed'] ?? null,
            'state' =>  $response['adresser'][0]['kommunenavn'] ?? null,
            'country_code' => 'NO',
            'country_name' => 'Norge',
            'longitude' => $response['adresser'][0]['representasjonspunkt']['lon']  ?? null,
            'latitude' => $response['adresser'][0]['representasjonspunkt']['lat']  ?? null,
            'mainland' => null,
            'response_json' => json_encode($response->json()) ?? null,
        ]);
    }

    protected function emptyAddressFromResponse(): AddressResponse
    {

        return new AddressResponse([
            'confidence' => "Unkown",
        ]);
    }

    public static function format_address_attributes(AddressRequest $address): string
    {
        return "{$address->street}, {$address->zip_code} {$address->city}";
    }
    /**
     * @param AddressRequest $address
     * @param array|AddressRequest $wash_results
     * @return Response
     */
    protected function searchForMathces(AddressRequest $address, Collection|AddressRequest $wash_results) : Response
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
