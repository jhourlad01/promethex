<?php

namespace Tests;

use Framework\TestCase;
use Framework\Request;
use App\Controllers\Api\AuthApiController;

class AuthApiTest extends TestCase
{
    private AuthApiController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AuthApiController();
    }

    public function testApiLoginWithValidCredentials(): void
    {
        $this->createTestUser([
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ]);

        $request = new Request();
        $request->setMethod('POST');
        $request->setBody(json_encode([
            'email' => 'test@example.com',
            'password' => 'password123'
        ]));
        $request->setHeader('Content-Type', 'application/json');

        $response = $this->controller->login($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonResponse(json_decode($response->getContent(), true), true);
    }

    public function testApiLoginWithInvalidCredentials(): void
    {
        $this->createTestUser([
            'email' => 'test@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ]);

        $request = new Request();
        $request->setMethod('POST');
        $request->setBody(json_encode([
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]));
        $request->setHeader('Content-Type', 'application/json');

        $response = $this->controller->login($request);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJsonResponse(json_decode($response->getContent(), true), false, 401);
    }

    public function testApiLoginWithMissingFields(): void
    {
        $request = new Request();
        $request->setMethod('POST');
        $request->setBody(json_encode([
            'email' => 'test@example.com'
            // Missing password
        ]));
        $request->setHeader('Content-Type', 'application/json');

        $response = $this->controller->login($request);

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonResponse(json_decode($response->getContent(), true), false, 422);
    }

    public function testApiLogout(): void
    {
        $user = $this->createTestUser();
        $this->loginUser($user);

        $request = new Request();
        $request->setMethod('POST');

        $response = $this->controller->logout($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonResponse(json_decode($response->getContent(), true), true);
        $this->assertGuest();
    }

    public function testApiGetUserWhenAuthenticated(): void
    {
        $user = $this->createTestUser();
        $this->loginUser($user);

        $request = new Request();
        $request->setMethod('GET');

        $response = $this->controller->user($request);

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertJsonResponse($responseData, true);
        $this->assertEquals($user['id'], $responseData['data']['user']['id']);
    }

    public function testApiGetUserWhenNotAuthenticated(): void
    {
        $request = new Request();
        $request->setMethod('GET');

        $response = $this->controller->user($request);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJsonResponse(json_decode($response->getContent(), true), false, 401);
    }
}
