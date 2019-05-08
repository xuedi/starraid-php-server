<?php

namespace App\Controller;

use App\Service\AuthenticationService;
use React\Http\Response;

/**
 * Class AbstractController
 * @package App\Entities
 */
abstract class AbstractController
{
    /** AuthenticationService */
    protected $authService = null;

    /**
     * AbstractController constructor.
     * @param AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param array $data
     * @return Response
     */
    public function jsonResponse(array $data): Response
    {
        echo ' [200]' . PHP_EOL;
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, true));
    }
}
