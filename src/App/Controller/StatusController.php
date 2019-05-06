<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
use Exception;
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
     * @throws Exception
     */
    private function __construct()
    {
        $this->objectService = ObjectService::getInstance();
        $this->authService = AuthenticationService::getInstance();
    }

    /**
     * @return StatusController
     * @throws Exception
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
        return $this->jsonResponse(
            [
                'msg' => 'No method requested',
                'methods' => [
                    'report' => 'general data overview',
                    'version' => 'current version',
                    'activeUser' => 'list of all currently active user',
                    'getAllObjects' => 'get every object in memory',
                ],
            ]
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function report(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            [
                'Ticks' => 0,
                'Objects' => $this->objectService->getStatus(),
            ]
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function version(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            [
                'version' => '0.1',
            ]
        );
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
    public function getAllObjects(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            $this->objectService->getObjectGroup()
        );
    }
}