<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use App\Services\GraphQLClient;

class EmailVerificationController extends Controller
{
    private GraphQLClient $graphqlClient;

    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }

    public function verify(): Response
    {
        $token = $this->request->getInput('token');

        if (empty($token)) {
            return $this->view('auth/verification-error', [
                'title' => 'Verification Error',
                'header_title' => 'Verification Failed',
                'header_subtitle' => 'There was an issue verifying your email.',
                'header_icon' => 'fas fa-exclamation-triangle',
                'message' => 'Invalid verification link. Token is missing.'
            ], 'clean');
        }

        try {
            $result = $this->graphqlClient->verifyEmail($token);

            if ($result && isset($result['token']) && isset($result['user'])) {
                // Store user data in session
                $_SESSION['user'] = $result['user'];
                $_SESSION['token'] = $result['token'];

                // Redirect to home with success message
                return $this->redirect('/?verified=1');
            } else {
                throw new \Exception('Email verification failed');
            }

        } catch (\Exception $e) {
            return $this->view('auth/verification-error', [
                'title' => 'Verification Error',
                'header_title' => 'Verification Failed',
                'header_subtitle' => 'There was an issue verifying your email.',
                'header_icon' => 'fas fa-exclamation-triangle',
                'message' => $e->getMessage()
            ], 'clean');
        }
    }
}
