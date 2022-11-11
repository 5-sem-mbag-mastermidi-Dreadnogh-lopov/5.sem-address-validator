<?php

namespace App\Models;

use Exception;
use Geocoder\Model\Address as GeocoderAddress;
use Geocoder\Model\AdminLevelCollection;
use Geocoder\Model\Coordinates;
use Geocoder\Model\Country;

class DawaAddress extends GeocoderAddress
{
    /** @var string|null */
    private $floor;
    /** @var string|null */
    private $door;

    private $accessAddressId;

    /**
     * DawaAddress constructor.
     *
     * @param Address|AccessAddress $address
     *
     * @throws DawaException
     */
    public function __construct(
        Address $address
    ) {
        if ($address instanceof Address) {
            parent::__construct(
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
