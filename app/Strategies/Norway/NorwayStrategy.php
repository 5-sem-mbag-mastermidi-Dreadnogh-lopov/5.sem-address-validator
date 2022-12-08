<?php

namespace App\Strategies\Norway;

use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Google\GoogleMapsProvider;
use App\Integrations\Kartverket\KartverketProvider;
use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;
use App\Strategies\AddressRequest\AddressRequestRuleInterface;
use App\Strategies\AddressRequest\StringReplaceRule;
use App\Strategies\Strategy;
use Illuminate\Support\Collection;
use App\Integrations\Confidence;

class NorwayStrategy implements Strategy
{
    private $providers = [
        KartverketProvider::class,
        GoogleMapsProvider::class,

    ];

    /** @var AddressRequestRuleInterface[] */
    public function __construct()
    {

    }

    public function validateAddress(AddressRequest $address): AddressResponse
    {
        $addresses = $this->wash($address);
        $res = new AddressResponse();
        foreach ($this->providers as $provider) {
            $res = $this->execute(new $provider(), $address, $addresses);
            if ($res['exact'] !== \App\Integrations\Confidence::Exact) {
                break;
            }
        }
        return $res;
    }

    public function execute(Provider $provider, AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
    {
        return $provider->ValidateAddress($address, $wash_results);
    }

    public function getRules(): array
    {
        $rules = WashRules::index();


        $ruleset = [];
        foreach ($rules as $rule => $value) {
            $ruleset[] = new StringReplaceRule($rule, $value);

        }
        return $ruleset;
    }

    public function wash(AddressRequest $address): Collection
    {
        $addresses = [];
        $rules = $this->getRules();
        foreach ($rules as $rule) {
            if (!$rule instanceof AddressRequestRuleInterface) {
                throw new \Exception('Rules for AddressRequest must implement the ' . AddressRequestRuleInterface::class);
            }
            $washed_street = $rule->apply($address);
            $addresses[] = $washed_street;
        }

        $collection = collect($addresses);
        return $collection->unique(function (AddressRequest $addressRequest) {
            $attributes = $addressRequest->attributesToArray();
            ksort($attributes);
            return serialize($attributes);
        });

    }
}
