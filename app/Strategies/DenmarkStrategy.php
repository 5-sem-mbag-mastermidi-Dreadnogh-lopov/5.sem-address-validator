<?php

namespace App\Strategies;

use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Provider;
use App\Models\AddressRequest;
use App\Models\AddressResponse;

class DenmarkStrategy implements Strategy
{
    private $providers = [DawaProvider::class];

    function ValidateAddress(AddressRequest $address)
    {
        foreach ($this->providers as $provider){
            $provider_class = new $provider();
            $res = $this->execute($provider_class, $address);
            if($res->category == 'exact'){
                dd($res);
            } else if($res->category == 'safe'){
                dd($res);
            }else if($res->category == 'unsure'){
                dd($res);
            }
        }
    }

    public function execute(Provider $provider, AddressRequest $address) : AddressResponse{
        return $provider->ValidateAddress($address);
    }
}
