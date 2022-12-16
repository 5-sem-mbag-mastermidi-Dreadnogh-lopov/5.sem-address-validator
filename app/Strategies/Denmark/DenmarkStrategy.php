<?php

namespace App\Strategies\Denmark;

use App\Integrations\Dao\DaoProvider;
use App\Integrations\Dawa\DawaProvider;
use App\Integrations\Google\GoogleMapsProvider;
use App\Strategies\BaseStrategy;

class DenmarkStrategy extends BaseStrategy
{
    protected array $providers = [
        DaoProvider::class,
        DawaProvider::class,
        GoogleMapsProvider::class,
    ];

    public function __construct()
    {
        $this->rules = include 'WashRules.php';
    }
}
