<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class SpaceshipEntity extends AbstractObject implements Database
{
    const TABLE = self::TYPE_SPACESHIP;
}