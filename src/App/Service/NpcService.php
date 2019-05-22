<?php declare(strict_types = 1);

namespace App\Service;

use App\Controller\AdminController;
use App\Controller\DefaultController;
use App\Controller\Interfaces\Routable;
use App\Controller\AuthenticationController;
use App\Controller\EntityController;
use App\Controller\StatusController;
use App\ValueObjects\Config;
use Pimple\Container;
use ReflectionClass;
use ReflectionException;

class NpcService
{
    public function tick(): void
    {
        echo "npcTick\n";
    }
}