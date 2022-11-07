<?php

namespace lib;

class DawaProvider implements Provider
{
    protected string $base_url = 'https://api.dataforsyningen.dk/';
    protected mixed $client;

    function ValidateAddress()
    {
        $endpoint = $this->base_url . 'adresse';
    }
}
