<?php

namespace App\Strategies\Norway;

use App\Integrations\Kartverket\KartverketProvider;
use App\Strategies\BaseStrategy;

class NorwayStrategy extends BaseStrategy
{
    protected array $providers = [
        KartverketProvider::class,
    ];

    public function __construct()
    {
        $this->rules = include 'WashRules.php';
    }
}
