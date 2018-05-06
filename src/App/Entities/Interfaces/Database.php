<?php

namespace App\Entities\Interfaces;

/**
 * Interface Database
 * @package App\Entities\Interfaces
 */
interface Database
{
    const TYPE_SPACESHIP = 'spaceship';
    const TYPE_CARGO = 'cargo';
    const TYPE_USER = 'user';

    /**
     * @param array $data
     * @return mixed
     */
    public function map(array $data);

    /**
     * @return string
     */
    public function getTableName(): string;
}