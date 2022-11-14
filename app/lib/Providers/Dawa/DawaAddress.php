<?php

namespace App\lib\Providers\Dawa;

use App\Models\AddressRequest;
use Exception;

class DawaAddress
{
    private ?string $floor;
    private ?string $door;

    private $accessAddressId;

    /**
     * DawaAddress constructor.
     *
     * @param AddressRequest $address
     *
     */
    public function __construct(
        AddressRequest $address
    ) {
        if ($address instanceof AddressRequest) {
            __construct(
                'dawa',
                new AdminLevelCollection(),
                new Coordinates($address->y, $address->x),
                null,
                $address->husnr,
                $address->vejnavn,
                $address->postnr,
                $address->postnrnavn,
                $address->supplerendebynavn,
                new Country('Denmark', 'DK'),
                // get_nearest_timezone($address->y, $address->x)
            );

            $this->floor           = $address->etage;
            $this->door            = $address->dør;
            $this->accessAddressId = $address->adgangsadresseid;
        } else {
            throw new Exception('Invalid argument for Geocoded address');
        }
    }

    public function getFloor()
    {
        return $this->floor;
    }

    public function getDoor()
    {
        return $this->door;
    }

    public function getAccessAddressId()
    {
        return $this->accessAddressId;
    }
}
