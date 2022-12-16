<?php

namespace App\Strategies\AddressRequest;

use App\Models\AddressRequest;
use function App\Strategies\str_starts_with;

class ArabicToRomanRule implements AddressRequestRuleInterface
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
        $exp = "/^\d*/";
        $exp_street_name = "/^(.+)(\s\d\w.*)$/i";

        // First, seperate street name from house number and split into array
        preg_match($exp_street_name, $request['street'], $matches_street);
        $exploded = explode(' ', trim($matches_street[1]));

        // Next, go through each item and replace numbers with roman letters. and add house number to the end
        $new_street = [];
        foreach ($exploded as $string) {
            if (preg_match($exp, $string, $matches) && !empty(array_filter($matches))) {
                $string = str_replace($matches[0], self::numberToRomanRepresentation($matches[0]), $string);
            }
            $new_street[] = $string;
        }
        $new_street[] = $matches_street[2] ?? null;

        // Lastly, put it all together again
        $request['street'] = join(' ', $new_street);
        return $request;
    }

    protected function numberToRomanRepresentation($number)
    {
        $returnValue = '';
        while ($number > 0) {
            foreach ($this->romans as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
