<?php

namespace Tests\Unit\Service;

use App\Entities\ActiveUser;
use App\Entities\UserEntity;
use App\Service\AuthenticationService;
use App\Service\EntityService;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\Unit\UnitTestBase;

class AuthenticationServiceTest extends UnitTestBase
{
    /** @var AuthenticationService */
    private $subject;

    /** @var MockObject|EntityService */
    private $objectService;

    /** @throws Exception */
    public function setUp(): void
    {
        $testUser = $this->createMock(UserEntity::class);
        $testUser->method('getName')->willReturn('test');
        $testUser->method('getPassword')->willReturn('1234');

        $this->objectService = $this->createMock(EntityService::class);
        $this->objectService->method('getObjectGroup')->willReturn([$testUser]);

        $this->subject = new AuthenticationService($this->objectService, 'TEST');
    }

    /**
     * @throws Exception
     */
    public function testAuthenticateFailed(): void
    {
        $actual = $this->subject->authenticate('meep', 'meep');
        $expected = [
            'success' => false,
            'token' => null
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @throws Exception
     */
    public function testAuthenticate(): void
    {
        $actual = $this->subject->authenticate('test', '1234');
        $this->assertTrue($actual['success']);
    }

    /**
     * @throws Exception
     */
    public function testGetList(): void
    {
        $this->subject->authenticate('test', '1234');

        $actualList = $this->subject->getList();
        $this->assertEquals(1, count($actualList));

        $actual = array_pop($actualList);
        $this->assertInstanceOf(ActiveUser::class, $actual);
    }

    /**
     * @throws Exception
     */
    public function testTick(): void
    {
        $this->subject->authenticate('test', '1234');

        $actual = $this->firstUserFromList($this->subject->getList());
        $this->assertEquals(0, $actual->getLaagCount());

        $this->subject->tick();
        $actual = $this->firstUserFromList($this->subject->getList());
        $this->assertEquals(1, $actual->getLaagCount());

        foreach (range(1, AuthenticationService::MAX_LAAG) as $laag) {
            $this->subject->tick();
        }
        $this->assertEquals([], $this->subject->getList());
    }

    public function firstUserFromList(array $list): ActiveUser
    {
        return array_pop($list);
    }
}
