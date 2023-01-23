<?php

namespace App\Integrations\Dao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaoAddressView extends Model
{
    use HasFactory;

    protected $table = 'dao_address_view';

    protected $fillable = [
        "id",
        "address_formatted",
        "post_nr"
    ];
}
