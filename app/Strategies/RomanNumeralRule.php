<?php

namespace App\Strategies;

class RomanNumeralRule
{
    protected $romans = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];


    public function apply(string $input): string
    {
        $exp = "/^[XVIMCDL]*[^s'.´]??/i";

        $exploded = explode(' ', $input);

        foreach ($exploded as $string) {
            preg_match($exp, $string, $matches);
            if (!empty($matches[0])) {
                $roman = $matches;
                break;
            }
        }

        if (!isset($roman)) {
            return false;
        }

        foreach ($roman as $numerals) {
            $result = 0;
            $match = $numerals;

            foreach ($this->romans as $key => $value) {
                while (str_starts_with(strtoupper($match), $key)) {
                    $result += $value;
                    $match = substr($match, strlen($key));
                }
            }

            $exploded[$numerals] = $result;
        }

        return join(' ', $exploded);
    }
}
