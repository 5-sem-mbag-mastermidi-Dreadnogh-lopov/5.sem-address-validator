<?php

namespace App\lib\Strategies\Countries;

use App\lib\Strategies\Strategy;
use App\lib\Providers\Dawa\DawaProvider;
use App\lib\Providers\Provider;
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
            if($res->categori == 'exact'){
                dd($res);
            } else if($res->categori == 'safe'){
                dd($res);
            }else if($res->categori == 'unsure'){
                dd($res);
            }
        }
    }

    public function execute(Provider $provider, AddressRequest $address) : AddressResponse{
        return $provider->ValidateAddress($address);
    }
}
