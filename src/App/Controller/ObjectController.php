<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Exceptions\AuthenticationException;
use App\Service\AuthenticationService;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class ObjectController
 * @package App\Controller
 */
class ObjectController extends AbstractController implements Routable
{
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

        return $this->jsonResponse([
            'msg' => 'No method requested',
            'methods' => [
                'index' => 'this page',
            ],
        ]);
    }
}