<?php

namespace App\Strategies;

use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;

class DenmarkStrategy implements Strategy
{
    private $providers = [DawaProvider::class];
    private $test_ruleset;

    public function __construct()
    {
        $this->test_ruleset = [
            new StringReplaceRule('alle', 'allé'),
            new StringReplaceRule('gammel', 'gl'),
            new StringReplaceRule('kgs', 'kongens'),
            new StringReplaceRule('kgs.', 'kongens'),
            new StringReplaceRule('sankt', 'skt'),
            new StringReplaceRule('christian', 'chr'),
            new StringReplaceRule('chr', 'chr.'),
            new StringReplaceRule('chr.', 'christian'),
            new StringReplaceRule('hc', 'h.c.'),
            //new RomanNumeralRule(), // kinda broken, uncommented for now
        ];
    }

    private $special_rules = [
        ' stuen' => ' st',
        'ae' => 'æ',
        'aa' => 'å',
        'oe' => "ø",
    ];

    function ValidateAddress(AddressRequest $address)
    {
        $addresses = $this->Wash($address);
        foreach ($this->providers as $provider) {
            $res = $this->execute(new $provider(), $address, $addresses);
        }

        return $res;
    }

    public function execute(Provider $provider, AddressRequest $address, array|AddressRequest $wash_results): AddressResponse
    {
        return $provider->ValidateAddress($address, $wash_results);
    }

    private function Wash(AddressRequest $address): array // TODO implement washing a little better, doesnt work with unique elements
    {
        $addresses = [];

        foreach ($this->test_ruleset as $rule) {
            $washed_street = $rule->apply($address->street);
            $new_address = clone $address;
            $address->street = $washed_street;
            $addresses[] = $new_address;
        }

        //return array_unique($addresses);
        return $addresses;
    }
}
