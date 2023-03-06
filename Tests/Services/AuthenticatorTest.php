<?php

namespace Tests\Services;

use App\Models\User;
use App\Services\Authenticator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase {
    
    /** @var MockObject */
    private User $user;

    const RIGHTPASS = "test";

    public function setUp(): void {
        $this->user = $this->createMock(User::class);

        $this->user->method('getPass')->willReturn("$2y$10$7hAdgg1dZsQz1wogPgevuuxeQhoZJSNdhIj/Gn9Apyh3EwqavcVQu");

    }

    public function testAuthenticatorMustReturnTrueWithRightPassword(): void {
        $this->assertTrue(Authenticator::authenticate($this->user, self::RIGHTPASS));
    }

    public function testAuthenticatorMustReturnFalseWithWrongPassword(): void {
        $this->assertFalse(Authenticator::authenticate($this->user, "wrong"));
    }

}