<?php

namespace App\Controller;

use React\Http\Response;

/**
 * Class AbstractController
 * @package App\Entities
 */
abstract class AbstractController
{
    /**
     * @param array $data
     * @return Response
     */
    public function jsonResponse(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, true));
    }
}