<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class CargoEntity extends AbstractObject implements Database
{
    const TABLE = self::TYPE_CARGO;
}