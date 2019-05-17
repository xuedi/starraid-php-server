<?php

namespace Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use React\Http\Response;
use ReflectionException;
use RingCentral\Psr7\ServerRequest;
use RingCentral\Psr7\Uri;

class UnitTestBase extends TestCase
{
    /**
     * @param string $uriPath
     * @param array $queryParams
     * @return ServerRequest
     * @throws ReflectionException
     */
    protected function createRequestMock(string $uriPath, array $queryParams = []): ServerRequest
    {
        /** @var MockObject|Uri $uriMock */
        $uriMock = $this->createMock(Uri::class);
        $uriMock->method('getPath')->willReturn($uriPath);

        /** @var MockObject|ServerRequest $request */
        $request = $this->createMock(ServerRequest::class);
        $request->method('getUri')->willReturn($uriMock);
        $request->method('getMethod')->willReturn('GET');
        $request->method('getQueryParams')->willReturn($queryParams);

        return $request;
    }

    /**
     * @param array $responseBody
     * @return Response
     */
    protected function createResponse(array $responseBody = []): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($responseBody));
    }

    /**
     * @param Response $expected
     * @param Response $actual
     */
    protected function assertResponseEquals(Response $expected, Response $actual): void
    {
        $this->assertEquals(
            $expected->getStatusCode(),
            $actual->getStatusCode()
        );
        $this->assertEquals(
            $expected->getProtocolVersion(),
            $actual->getProtocolVersion()
        );

        $this->assertEquals(
            $expected->getBody()->getContents(),
            $actual->getBody()->getContents()
        );
    }
}