<?php

namespace App\Packages\CastableDataTransferObject\Values;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

class Address extends CastableDataTransferObject
{
    public string $street;
    public string $suburb;
    public string $state;

    public function fullAddress(): string
    {
        return "{$this->street}, {$this->suburb} - {$this->state}";
    }
}
