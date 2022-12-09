<?php

namespace App\Integrations\Dao;

use App\Integrations\Confidence;
use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Support\Collection;

class DaoProvider implements Provider
{

    function validateAddress(AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
    {
        //dump($wash_results);
        $lookup = $this->searchForMathces($address, $wash_results);
        //dump($lookup);
        $res = $this->addressFromResponse($lookup);
        //dd($res);
        return $res;
    }

    protected function addressFromResponse(DaoAddress $response, array $extra = null): AddressResponse
    {
        return new AddressResponse([
            'confidence'        => $response['confidence'] ?? Confidence::Exact,
            'address_formatted' => $response['address_formatted'] . ", Danmark",
            'street_name'       => $response['gadenavn'],
            'street_number'     => $response['hus_nr'] . $response['opgang'],
            'zip_code'          => $response['post_nr'],
            'city'              => $response['post_distrikt'],
            'country_code'      => 'DK',
            'country_name'      => 'Denmark',
            'longitude'         => $response['laengdegrad'],
            'latitude'          => $response['breddegrad'],
            'response_json'     => json_encode($response->attributesToArray()),
        ]);
    }

    protected function searchForMathces(AddressRequest $address, Collection|AddressRequest $wash_results): DaoAddress
    {
        $matches = [];
        // Explain: (street_name)(street_number)(opgang) first match is all together
        $exp = "/(^\D*\d??)(\d*\w??)(\w*\D??)/";
        preg_match($exp, $address->street, $matches);
        $matches = array_filter(array_map('trim', $matches));
        //dump($matches);
        $raw_query = DaoAddress::firstOrNew([
            'post_nr'          => $address->zip_code ?? null,
            'post_distrikt'    => $address['city'] ?? null,
            'gadenavn_synonym' => $matches[1] ?? null,
            'hus_nr'           => $matches[2] ?? null,
            'opgang'           => $matches[3] ?? null,
        ], [
            'confidence' => Confidence::Unknown
        ]);
        /*
        $formatted_address = self::address_formatted($address);
        //dump($formatted_address);
        $raw_query = DB::raw(<<<pgsql
         select * from (
            SELECT
                id,
                address_formatted,
                levenshtein_less_equal(lower(address_formatted), :str, length(:str)/3) as distance
            FROM dao_address_view
        ) as res
        join dao_address as dao on dao.id = res.id
        where res.distance < length(:str)/3+1
        ORDER BY distance ASC
        LIMIT 1
pgsql
        );

        $query_select = DB::select($raw_query, ['str' => $formatted_address]);
        $new_res = new DaoAddress((array)($query_select[0] ?? null));

        return $new_res;
        */
        return $raw_query;
    }

    protected static function address_formatted(AddressRequest $address)
    {
        return "{$address['street']}, {$address['zip_code']} {$address['city']}";
    }
}
