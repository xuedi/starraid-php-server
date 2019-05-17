<?php

namespace Tests\Integration;

use App\Service\RoutingService;
use Exception;
use ReflectionException;

class LoginTest extends IntegrationTestBase
{
    /** @var RoutingService */
    private $subject;

    /** @var string */
    private $appToken;

    /** @throws Exception */
    public function setUp(): void
    {
        $this->appToken = 'test';
        $this->subject = new RoutingService($this->getContainerMock());
    }

    /**
     *
     * @throws ReflectionException
     * @throws Exception
     */
    public function testCanNotLogin(): void
    {
        $this->markTestSkipped();

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
        $this->markTestSkipped();

        $responseBody = ['success' => true, 'token' => 'a0f52f45-6aab-449f-b952-08fff7542f19'];
        $expected = $this->createResponse($responseBody);

        $queryParams = ['user' => 'xuedi', 'pass' => '12345'];
        $request = $this->createRequestMock('/login', $queryParams);

        $actual = $this->subject->dispatch($request);

        $this->assertResponseEquals($expected, $actual);
    }
}
