<?php

namespace Tests\TestCase\Domain\User\Service;

use App\Domain\User\Repository\UserCreatorRepository;
use App\Domain\User\Service\UserCreator;
use PHPUnit\Framework\TestCase;
use Tests\AppTestTrait;

/**
 * Tests.
 */
class UserCreatorTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test.
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        // Mock the required repository method
        $this->mock(UserCreatorRepository::class)->method('insertUser')->willReturn(1);

        $service = $this->container->get(UserCreator::class);

        $user = [
            'username' => 'john.doe',
            'password' => 'passwd',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'profile' => 'user'
        ];

        $actual = $service->createUser($user);

        static::assertSame(1, $actual);
    }
}
