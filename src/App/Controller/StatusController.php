<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class StatusController
 * @package App\Controller
 */
class StatusController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objects = null;

    /** @var StatusController */
    private static $instance;

    /**
     * StatusController constructor.
     */
    private function __construct()
    {
        $this->objects = \App\Service\ObjectService::getInstance();
    }

    /**
     * @return StatusController
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new StatusController();
        }
        return self::$instance;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse([
            'msg' => 'No method requested',
            'methods' => [
                'index' => 'this page',
                'report' => 'general data overview',
                'version' => 'current version',
            ],
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function report(ServerRequestInterface $request): Response
    {
        $report = [
            'Ticks' => 0,
            'Objects' => $this->objects->getStatus(),
        ];
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($report, true));
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function version(ServerRequestInterface $request): Response
    {
        $version = [
            'version' => '0.1',
        ];
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($version, true));
    }
}