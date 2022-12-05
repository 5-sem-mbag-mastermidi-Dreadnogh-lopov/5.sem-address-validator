<?php

namespace App\Integrations;

use App\Models\AddressRequest;
use App\Models\AddressResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

abstract class BaseProvider implements Provider
{
    protected abstract function addressFromResponse(Response $response, array $extra = null): AddressResponse;

    protected abstract function searchForMathces(AddressRequest $address, Collection|AddressRequest $wash_results): Response;

    protected abstract static function convert_confidence(mixed $determinant): Confidence;

    protected abstract static function format_street_number(Response $response): string;
}
