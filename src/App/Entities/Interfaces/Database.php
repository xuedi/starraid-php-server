<?php

namespace App\Entities\Interfaces;

interface Database
{
    const TYPE_SPACESHIP = 'spaceship';
    const TYPE_CARGO = 'cargo';

    public function load();

    public function save();
}