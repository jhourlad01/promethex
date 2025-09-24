<?php

namespace Framework;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Framework\Database;
use Framework\Auth;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clear any existing session data
        $_SESSION = [];
        
        // Logout any authenticated user
        Auth::logout();
        
        // Set up database for testing
        $this->setUpDatabase();
    }

    protected function tearDown(): void
    {
        // Clean up after each test
        $_SESSION = [];
        Auth::logout();
        
        parent::tearDown();
    }

    /**
     * Set up database for testing
     */
    protected function setUpDatabase(): void
    {
        // Clear existing data
        $this->clearDatabase();
        
        // Run migrations for testing
        $this->runMigrations();
    }

    /**
     * Clear database tables
     */
    protected function clearDatabase(): void
    {
        // For SQLite in-memory, we need to ensure tables are dropped
        $tables = ['users', 'products', 'migrations', 'seeders'];
        
        foreach ($tables as $table) {
            try {
                \Illuminate\Database\Capsule\Manager::schema()->dropIfExists($table);
            } catch (\Exception $e) {
                // Table might not exist, ignore
            }
        }
    }

    /**
     * Run migrations for testing
     */
    protected function runMigrations(): void
    {
        // Run migrations for testing
        $migrationRunner = new MigrationRunner();
        $migrationRunner->run();
    }

    /**
     * Create a test user
     */
    protected function createTestUser(array $attributes = []): array
    {
        $defaults = [
            'name' => 'Test User',
            'email' => 'test' . uniqid() . '@example.com', // Make email unique
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userData = array_merge($defaults, $attributes);
        
        // Insert user into database
        $userId = \Illuminate\Database\Capsule\Manager::table('users')->insertGetId($userData);
        $userData['id'] = $userId;
        
        return $userData;
    }

    /**
     * Login a test user
     */
    protected function loginUser(array $user): void
    {
        Auth::login($user);
    }

    /**
     * Assert that a user is authenticated
     */
    protected function assertAuthenticated(): void
    {
        $this->assertTrue(Auth::check(), 'User should be authenticated');
    }

    /**
     * Assert that a user is not authenticated
     */
    protected function assertGuest(): void
    {
        $this->assertFalse(Auth::check(), 'User should not be authenticated');
    }

    /**
     * Assert that a user has a specific role
     */
    protected function assertUserHasRole(array $user, string $role): void
    {
        $this->assertEquals($role, $user['role'], "User should have role '{$role}'");
    }

    /**
     * Assert JSON response structure
     */
    protected function assertJsonResponse(array $response, bool $success = true, int $statusCode = 200): void
    {
        $this->assertArrayHasKey('success', $response);
        $this->assertEquals($success, $response['success']);
        
        if ($success) {
            $this->assertArrayHasKey('data', $response);
        } else {
            $this->assertArrayHasKey('message', $response);
        }
    }
}