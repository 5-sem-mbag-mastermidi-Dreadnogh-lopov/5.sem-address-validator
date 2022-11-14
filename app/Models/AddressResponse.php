<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResponse extends Model
{
    use hasFactory;

    protected $fillable = [
        'id',
        'category',
        'street',
        'number',
        'floor',
        'door',
        'zip_code',
        'city'
    ];
}
