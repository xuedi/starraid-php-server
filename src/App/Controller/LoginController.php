<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objects = null;

    /** @var LoginController */
    private static $instance;

    /**
     * LoginController constructor.
     */
    private function __construct()
    {
        $this->objects = \App\Service\ObjectService::getInstance();
    }

    /**
     * @return LoginController
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new LoginController();
        }
        return self::$instance;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        $user = $request->getQueryParams()['user'] ?? null;
        $pass = $request->getQueryParams()['pass'] ?? null;
        return $this->jsonResponse([
            'user' => $user,
            'pass' => $pass,
        ]);
    }
}