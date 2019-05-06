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
    /** @var DefaultController */
    private static $instance;

    /**
     * @return DefaultController
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DefaultController();
        }

        return self::$instance;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse([
            'msg'     => 'No method requested',
            'methods' => [
                'index'          => 'this page',
                'report'         => 'general data overview',
                'version'        => 'current version',
                'activeUser'     => 'list of all currently active user',
                'getObjectGroup' => 'get all objects by group',
                'getObject'      => 'gets single object by group and id',
            ],
        ]);
    }
}
