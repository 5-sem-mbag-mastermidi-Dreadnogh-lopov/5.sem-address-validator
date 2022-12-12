<?php

namespace App\Integrations;

use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

abstract class BaseProvider implements Provider
{
    protected abstract function addressFromResponse(Response $response, array $extra = null): AddressResponse;

    protected abstract function searchForMatches(AddressRequest $address, Collection|AddressRequest $wash_results): Response;
}
