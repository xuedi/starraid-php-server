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

    /** @var ObjectController */
    private static $instance;

    /**
     * ObjectController constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * @return ObjectController
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ObjectController();
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
            'msg' => 'No method requested',
            'methods' => [
                'index' => 'this page',
            ],
        ]);
    }
}