<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Exceptions\AuthenticationException;
use App\Service\AuthenticationService;
use App\Service\EntityService;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class AdminController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objectService = null;

    /**
     * AdminController constructor.
     * @param EntityService $objectService
     * @param AuthenticationService $authService
     */
    public function __construct(EntityService $objectService, AuthenticationService $authService)
    {
        parent::__construct($authService);
        $this->objectService = $objectService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws AuthenticationException
     */
    public function index(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_ADMIN,
            $request->getQueryParams()['token'] ?? null
        );

        return $this->jsonResponse(
            [
                'msg' => 'Nothing to see here',
            ]
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws AuthenticationException
     */
    public function map(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_ADMIN,
            $request->getQueryParams()['token'] ?? null
        );

        return $this->jsonResponse(
            $this->objectService->getObjectGroup()
        );
    }
}
