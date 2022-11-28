<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressResponse extends Model
{
    use hasFactory;

    protected $table = 'address';

    protected $fillable = [
        'confidence',
        'address_formatted',
        'street_name',
        'street_number',
        'zip_code',
        'city',
        'state',
        'country_code',
        'country_name',
        'latitude',
        'longitude',
        'mainland',
        'response_json'
    ];

    protected $visible = [
        'id',
        'confidence',
        'address_formatted',
        'street_name',
        'street_number',
        'zip_code',
        'city',
        'state',
        'country_code',
        'country_name',
        'latitude',
        'longitude',
        'mainland',
        'response_json'
    ];
}
