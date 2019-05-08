<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
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
     */
    public function index(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse([
            'msg' => 'No method requested',
            'methods' => [
                'index' => 'this page',
            ],
        ]);
    }
}