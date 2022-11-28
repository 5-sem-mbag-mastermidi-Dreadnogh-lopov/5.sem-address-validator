<?php

namespace App\Strategies\Denmark;

use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Strategies\AddressRequest\AddressRequestRuleInterface;
use App\Strategies\AddressRequest\StringReplaceRule;
use App\Strategies\Strategy;
use Illuminate\Support\Collection;

class DenmarkStrategy implements Strategy
{
    private $providers = [DawaProvider::class];

    /** @var AddressRequestRuleInterface[] */
    private array $ruleset = [];

    public function __construct()
    {
        $rules = WashRules::index();

        foreach ($rules as $rule => $value) {
            $this->ruleset[] = new StringReplaceRule($rule, $value);
        }
    }

    function validateAddress(AddressRequest $address)
    {
        $addresses = $this->wash($address);
        foreach ($this->providers as $provider) {
            $res = $this->execute(new $provider(), $address, $addresses);
        }

        return $res;
    }

    public function execute(Provider $provider, AddressRequest $address, array|AddressRequest $wash_results): AddressResponse
    {
        return $provider->ValidateAddress($address, $wash_results);
    }

    private function wash(AddressRequest $address): Collection // TODO implement washing a little better, doesnt work with unique elements
    {
        $addresses = [];
        $rules = $this->ruleset;
        foreach ($rules as $rule) {
            if (!$rule instanceof AddressRequestRuleInterface) {
                throw new \Exception('Rules for AddressRequest must implement the ' . AddressRequestRuleInterface::class);
            }
            $washed_street = $rule->apply($address);
            $addresses[] = $washed_street;
        }

        $collection = collect($addresses);
        $unique = $collection->unique(function (AddressRequest $addressRequest) {
            $attributes = $addressRequest->attributesToArray();
            ksort($attributes);
            return serialize($attributes);
        });

        return $unique;
    }
}
