<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashRequest extends Model
{
    use HasFactory;

    protected $table = 'hash_request';

    protected $fillable = [
        'hash_key',
        'request',
        'address_id',
        'created_at',
    ];

}
