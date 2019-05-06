<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
use Exception;
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

    /** AuthenticationService */
    private $authService = null;

    /** @var LoginController */
    private static $instance;

    /**
     * LoginController constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $this->objects = ObjectService::getInstance();
        $this->authService = AuthenticationService::getInstance();
    }

    /**
     * @return LoginController
     * @throws Exception
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
     * @throws Exception
     */
    public function index(ServerRequestInterface $request): Response
    {
        $user = $request->getQueryParams()['user'] ?? null;
        $pass = $request->getQueryParams()['pass'] ?? null;

        return $this->jsonResponse($this->authService->authenticate($user, $pass));
    }
}