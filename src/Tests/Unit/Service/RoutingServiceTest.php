<?php

namespace Tests\Unit\Service;

use App\Service\AuthenticationService;
use App\Service\RoutingService;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Pimple\Container;
use Ramsey\Uuid\Uuid;
use ReflectionException;
use Tests\Unit\UnitTestBase;

class RoutingServiceTest extends UnitTestBase
{
    /** @var RoutingService */
    private $subject;

    /** @var string */
    private $appToken;

    /** @var AuthenticationService */
    private $authenticationService;

    /** @throws Exception */
    public function setUp(): void
    {
        /** @var MockObject|Container $ctn */
        $ctn = $this->createMock(Container::class);

        //$ctn->method()->with('')->willReturn()

        $this->appToken = 'test';
        $this->subject = new RoutingService($ctn);

        $this->authenticationService = $this->createMock(AuthenticationService::class);
        $this->authenticationService->method('authenticate')->willReturn(
            [
                'success' => true,
                'token' => Uuid::uuid4()->toString(),
            ]
        );
    }

    /**
     * @param string $controllerName
     * @throws ReflectionException
     * @dataProvider getControllerNames
     */
    public function testControllerRouting(string $controllerName): void
    {
        $this->markTestSkipped();

        $responseBody = ['success' => true, 'token' => 'a0f52f45-6aab-449f-b952-08fff7542f19'];
        $expected = $this->createResponse($responseBody);

        $queryParams = ['user' => 'xuedi', 'pass' => '12345'];
        $request = $this->createRequestMock('/' . $controllerName, $queryParams);

        $actual = $this->subject->dispatch($request);

        $this->assertResponseEquals($expected, $actual);
    }

    public function getControllerNames()
    {
        return [
            'login' => ['login'],
            //'admin' => ['admin'],
            //'entity' => ['entity'],
            //'status' => ['status'],
        ];
    }
}
