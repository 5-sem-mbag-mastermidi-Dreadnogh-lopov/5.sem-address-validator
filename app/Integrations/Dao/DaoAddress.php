<?php

namespace App\Integrations\Dao;

use App\Integrations\Confidence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaoAddress extends Model
{
    use HasFactory;

    protected $table = 'dao_address';

    protected $fillable = [
        "confidence",
        "distance",
        "address_formatted",
        "post_nr",
        "post_distrikt",
        "gadenavn",
        "gadenavn_synonym",
        "hus_nr",
        "opgang",
        "laengdegrad",
        "breddegrad"
    ];

    protected $attributes = [
        'confidence' => Confidence::Unknown
    ];
}
