<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class LoginController extends AbstractController implements Routable
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    public function index(ServerRequestInterface $request): Response
    {
        $user = $request->getQueryParams()['user'] ?? null;
        $pass = $request->getQueryParams()['pass'] ?? null;

        return $this->jsonResponse($this->authService->authenticate($user, $pass));
    }
}
