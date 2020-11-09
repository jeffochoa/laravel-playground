<?php

namespace App\Packages\CastableDataTransferObject\Models;

use App\Packages\CastableDataTransferObject\Values\Address;
use Illuminate\Database\Eloquent\Model;

class UserWithCastableDataTransferObject extends Model
{
    protected $guarded = [];

    protected $casts = [
        'address' => Address::class
    ];
}
