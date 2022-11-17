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
            new RomanNumeralRule(),
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
            $res = $this->execute(new $provider(), $address);
            if ($res->category == 'exact') {
                dd($res);
            } else if ($res->category == 'safe') {
                dd($res);
            } else if ($res->category == 'uncertain') {
                dd($res);
            }
        }
    }

    public function execute(Provider $provider, AddressRequest $address): AddressResponse
    {
        return $provider->ValidateAddress($address);
    }

    private function Wash(AddressRequest $address): array
    {
        $addresses = [];

        foreach ($this->test_ruleset as $rule) {
            $addresses[] = $rule->apply($address->street);
        }

        return array_unique($addresses);
    }
}
