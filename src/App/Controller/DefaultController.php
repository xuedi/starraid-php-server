<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController implements Routable
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            [
                'msg' => 'This are the default Controller',
                'methods' => [
                    'admin',
                    'login',
                    'object',
                    'status',
                ],
            ]
        );
    }
}
