<?php declare(strict_types = 1);

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

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
