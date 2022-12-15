<?php

namespace App\Strategies;

use App\Integrations\Confidence;
use App\Integrations\Google\GoogleMapsProvider;
use App\Integrations\Provider;
use app\models\AddressRequest;
use App\Models\AddressResponse;
use App\Strategies\AddressRequest\AddressRequestRuleInterface;
use App\Strategies\AddressRequest\ArabicToRomanRule;
use App\Strategies\AddressRequest\StringReplaceRule;
use Illuminate\Support\Collection;

class BaseStrategy implements Strategy
{
    protected array $providers = [
        GoogleMapsProvider::class,
    ];

    protected $rules = [];

    public function validateAddress(AddressRequest $address): AddressResponse
    {
        $addresses = $this->wash($address);

        $res = [];
        foreach ($this->providers as $provider) {
            $tmp = $this->execute(new $provider(), $address, $addresses);
            if ($tmp['confidence'] == Confidence::Exact) {
                break;
            }
            $res[] = $tmp;
        }

        //dump($res);
        usort($res, function ($a, $b) {
            $order = [
                1 => Confidence::Exact,
                2 => Confidence::Sure,
                3 => Confidence::Unsure,
                4 => Confidence::Unknown
            ];

            return $order[array_search($a['confidence'], $order)] > $order[array_search($a['confidence'], $order)];
        });
        //dd($res);

        return $res[0];
    }

    public function execute(Provider $provider, AddressRequest $address, Collection|AddressRequest $wash_results): AddressResponse
    {
        return $provider->ValidateAddress($address, $wash_results);
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

    public function getRules(): array
    {
        $ruleset = [];
        foreach ($this->rules as $rule => $value) {
            $ruleset[] = new StringReplaceRule($rule, $value);
        }

        //Extra rules
        $ruleset[] = new ArabicToRomanRule();

        return $ruleset;
    }
}
