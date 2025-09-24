<?php

namespace Tests;

use Framework\TestCase;
use Framework\Auth;

class AuthTest extends TestCase
{
    public function testUserCanLogin(): void
    {
        $user = $this->createTestUser([
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ]);

        $this->assertGuest();

        $result = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $this->assertTrue($result);
        $this->assertAuthenticated();
    }

    public function testUserCannotLoginWithWrongPassword(): void
    {
        $this->createTestUser([
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ]);

        $result = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->assertFalse($result);
        $this->assertGuest();
    }

    public function testUserCanLogout(): void
    {
        $user = $this->createTestUser();
        $this->loginUser($user);

        $this->assertAuthenticated();

        Auth::logout();

        $this->assertGuest();
    }

    public function testAuthUserReturnsCurrentUser(): void
    {
        $user = $this->createTestUser();
        $this->loginUser($user);

        $currentUser = Auth::user();

        $this->assertNotNull($currentUser);
        $this->assertEquals($user['id'], $currentUser['id']);
        $this->assertEquals($user['email'], $currentUser['email']);
    }

    public function testAuthIdReturnsUserId(): void
    {
        $user = $this->createTestUser();
        $this->loginUser($user);

        $this->assertEquals($user['id'], Auth::id());
    }

    public function testAuthCheckReturnsCorrectStatus(): void
    {
        $this->assertFalse(Auth::check());
        $this->assertTrue(Auth::guest());

        $user = $this->createTestUser();
        $this->loginUser($user);

        $this->assertTrue(Auth::check());
        $this->assertFalse(Auth::guest());
    }
}
