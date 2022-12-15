<?php

namespace App\Strategies\AddressRequest;

use App\Models\AddressRequest;
use function App\Strategies\str_starts_with;

class RomanToArabicRule implements AddressRequestRuleInterface
{
    protected array $romans = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1,
    ];


    public function apply(AddressRequest $request): AddressRequest
    {
        $exp = "/^[XVIMCDL]*[^s'.´]??/i";

        $exploded = explode(' ', $request['street']);
        $new_street = [];

        foreach ($exploded as $string) {
            if (preg_match($exp, $string, $matches)) {
                $string = self::numberToRomanRepresentation($matches[0]);
            }
            $new_street[] = $string;
        }

        $request['street'] = join(' ', $new_street);
        dd($request);
        return $request;
    }
}
