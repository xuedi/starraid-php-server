<?php

use App\Service\AuthenticationService;
use App\Service\DatabaseService;
use App\Service\EntityService;
use App\Service\RoutingService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use React\Http\Response;
use RingCentral\Psr7\ServerRequest;
use RingCentral\Psr7\Uri;

class LoginTest extends TestCase
{
    /** @var RoutingService */
    private $subject;

    /** @var string */
    private $appToken;

    /** @throws Exception */
    public function setUp(): void
    {
        $this->appToken = 'test';
        $this->subject = new RoutingService();
        AuthenticationService::getInstance($this->appToken);

        $database = DatabaseService::getInstance('../../config/config.json');
        $objects = EntityService::getInstance();
        $objects->init($database);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testCanNotLogin(): void
    {
        $responseBody = ['success' => false, 'token' => null];
        $expected = $this->createResponse($responseBody);

        $queryParams = ['user' => 'xuedi', 'pass' => 'wrongPassword'];
        $request = $this->createRequestMock('/login', $queryParams);

        $actual = $this->subject->dispatch($request);

        $this->assertResponseEquals($expected, $actual);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function testCanLogin(): void
    {
        $responseBody = ['success' => true, 'token' => 'a0f52f45-6aab-449f-b952-08fff7542f19'];
        $expected = $this->createResponse($responseBody);

        $queryParams = ['user' => 'xuedi', 'pass' => '12345'];
        $request = $this->createRequestMock('/login', $queryParams);

        $actual = $this->subject->dispatch($request);

        $this->assertResponseEquals($expected, $actual);
    }






    //TODO: move to abstract

    /**
     * @param string $uriPath
     * @param array $queryParams
     * @return ServerRequest
     * @throws ReflectionException
     */
    private function createRequestMock(string $uriPath, array $queryParams = []): ServerRequest
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
    private function createResponse(array $responseBody = []): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($responseBody));
    }

    /**
     * @param Response $expected
     * @param Response $actual
     */
    private function assertResponseEquals(Response $expected, Response $actual): void
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