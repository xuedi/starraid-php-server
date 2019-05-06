<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use App\Service\AuthenticationService;
use App\Service\ObjectService;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController implements Routable
{
    /** ObjectService */
    private $objectService = null;

    /** AuthenticationService */
    private $authService = null;

    /** @var StatusController */
    private static $instance;

    /**
     * AdminController constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $this->objectService = ObjectService::getInstance();
        $this->authService = AuthenticationService::getInstance();
    }

    /**
     * @return AdminController|StatusController
     * @throws Exception
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AdminController();
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
            'msg' => 'Nothing to see here',
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function map(ServerRequestInterface $request): Response
    {
        return $this->jsonResponse(
            $this->objectService->getObjectGroup()
        );
    }
}