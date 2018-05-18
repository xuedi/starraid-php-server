<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
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
     * StatusController constructor.
     */
    private function __construct()
    {
        $this->objectService = \App\Service\ObjectService::getInstance();
        $this->authService = \App\Service\AuthenticationService::getInstance();
    }

    /**
     * @return StatusController
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
            $this->objectService->getObjects()
        );
    }
}