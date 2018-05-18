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
    private $objectService = null;

    /** AuthenticationService */
    private $authService = null;

    /** @var StatusController */
    private static $instance;

    /**
     * StatusController constructor.
     */
    private function __construct()
    {
        $this->objectService = \App\Service\ObjectService::getInstance();
        $this->authService = \App\Service\AuthenticationService::getInstance();
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
            'msg'     => 'No method requested',
            'methods' => [
                'index'          => 'this page',
                'report'         => 'general data overview',
                'version'        => 'current version',
                'activeUser'     => 'list of all currently active user',
                'getObjectGroup' => 'get all objects by group',
                'getObject'      => 'gets single object by group and id',
            ],
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function report(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse([
            'Ticks'   => 0,
            'Objects' => $this->objectService->getStatus(),
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function version(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse([
            'version' => '0.1',
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function activeUser(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            $this->authService->getList()
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function getObjects(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            $this->objectService->getObjectGroup()
        );
    }
}