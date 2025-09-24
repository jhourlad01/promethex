<?php

namespace Tests;

use Framework\TestCase;
use App\Models\User;

class UserModelTest extends TestCase
{
    public function testUserCanBeCreated(): void
    {
        $user = User::createUser([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue($user->verifyPassword('password123'));
    }

    public function testUserRoleMethods(): void
    {
        $admin = User::createUser([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin'
        ]);

        $user = User::createUser([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user'
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isUser());
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($admin->hasAnyRole(['admin', 'moderator']));

        $this->assertTrue($user->isUser());
        $this->assertFalse($user->isAdmin());
        $this->assertTrue($user->hasRole('user'));
    }

    public function testUserScopes(): void
    {
        // Create test users
        User::createUser([
            'name' => 'Active User',
            'email' => 'active@example.com',
            'password' => 'password123',
            'is_active' => true
        ]);

        User::createUser([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => 'password123',
            'is_active' => false
        ]);

        User::createUser([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
            'is_active' => false  // Make admin inactive for this test
        ]);

        // Test scopes
        $activeUsers = User::active()->get();
        $this->assertCount(1, $activeUsers);
        $this->assertEquals('Active User', $activeUsers->first()->name);

        $admins = User::admins()->get();
        $this->assertCount(1, $admins);
        $this->assertEquals('Admin User', $admins->first()->name);
    }

    public function testUserAccessors(): void
    {
        $user = User::createUser([
            'name' => 'John Doe Smith',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $this->assertEquals('John Doe Smith', $user->full_name);
        $this->assertEquals('JD', $user->initials);
        $this->assertEquals('John Doe Smith', $user->display_name);
        $this->assertStringContainsString('ui-avatars.com', $user->avatar_url);
    }

    public function testUserApiArray(): void
    {
        $user = User::createUser([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role' => 'user'
        ]);

        $apiArray = $user->toApiArray();

        $this->assertArrayHasKey('id', $apiArray);
        $this->assertArrayHasKey('name', $apiArray);
        $this->assertArrayHasKey('email', $apiArray);
        $this->assertArrayHasKey('role', $apiArray);
        $this->assertArrayHasKey('initials', $apiArray);
        $this->assertArrayHasKey('display_name', $apiArray);
        $this->assertArrayHasKey('avatar_url', $apiArray);
        $this->assertArrayNotHasKey('password', $apiArray);
    }
}
