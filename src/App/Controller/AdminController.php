<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objectService = null;

    /** AuthenticationService */
    private $authService = null;

    /**
     * AdminController constructor.
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
        return $this->jsonResponse([
            'msg' => 'Nothing to see here',
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function map(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            $this->objectService->getObjectGroup()
        );
    }
}
