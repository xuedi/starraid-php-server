<?php declare(strict_types = 1);

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Exceptions\AuthenticationException;
use App\Service\AuthenticationService;
use App\Service\EntityService;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class StatusController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objectService = null;

    /**
     * StatusController constructor.
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
     * @throws AuthenticationException
     */
    public function update(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_USER,
            $request->getQueryParams()['token'] ?? null
        );

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
     * @throws AuthenticationException
     */
    public function report(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_ADMIN,
            $request->getQueryParams()['token'] ?? null
        );

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
     * @throws AuthenticationException
     */
    public function version(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_ADMIN,
            $request->getQueryParams()['token'] ?? null
        );

        return $this->jsonResponse(
            [
                'version' => '0.1',
            ]
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws AuthenticationException
     */
    public function activeUser(ServerRequestInterface $request): Response
    {
        $this->authService->checkPrivilege(
            AuthenticationService::ROLE_ADMIN,
            $request->getQueryParams()['token'] ?? null
        );

        return $this->jsonResponse(
            $this->authService->getList()
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws AuthenticationException
     */
    public function getAllObjects(ServerRequestInterface $request): Response
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