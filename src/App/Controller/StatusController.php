<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
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

    /**
     * StatusController constructor.
     * @param ObjectService $objectService
     * @param AuthenticationService $authService
     */
    public function __construct(ObjectService $objectService, AuthenticationService $authService)
    {
        $this->objectService = $objectService;
        $this->authService = $authService;
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