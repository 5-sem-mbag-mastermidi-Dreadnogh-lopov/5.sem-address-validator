<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'state',
        'zip_code',
        'city',
        'country_code'
    ];

    protected $attributes = [
        'state' => null,
        'city' => null,
    ];
}
