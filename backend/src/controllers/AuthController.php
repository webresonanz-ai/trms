<?php

declare(strict_types=1);

namespace TRMS\Controllers;

use TRMS\Core\Response;
use TRMS\Models\User;
use TRMS\Middleware\Auth;

class AuthController
{
    public function login(): void
    {
        $input = $this->getJsonInput();

        if (empty($input['email']) || empty($input['password'])) {
            Response::validationError(['credentials' => 'Email and password are required']);
        }

        $userModel = new User();
        $user = $userModel->findByEmail($input['email']);

        if (!$user || !password_verify($input['password'], $user['password'])) {
            Response::error('Invalid credentials', 401);
        }

        unset($user['password']);

        $token = Auth::generateToken($user);

        Response::json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function register(): void
    {
        $input = $this->getJsonInput();
        $errors = $this->validateRegistration($input);

        if ($errors) {
            Response::validationError($errors);
        }

        $userModel = new User();

        if ($userModel->findByEmail(strtolower(trim($input['email'])))) {
            Response::validationError(['email' => 'Email is already registered']);
        }

        $userId = $userModel->createUser([
            'name' => trim($input['name']),
            'email' => strtolower(trim($input['email'])),
            'password' => $input['password'],
            'role' => 'user',
        ]);

        $user = $userModel->find('users', $userId);

        if (!$user) {
            Response::serverError('Unable to create user');
        }

        unset($user['password']);

        $token = Auth::generateToken($user);

        Response::json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function me(): void
    {
        Auth::handle();

        $payload = Auth::getPayloadFromHeader();

        if (!$payload || !isset($payload['sub'])) {
            Response::error('Invalid token', 401);
        }

        $userModel = new User();
        $user = $userModel->find('users', (int) $payload['sub']);

        if (!$user) {
            Response::notFound('User not found');
        }

        unset($user['password']);

        Response::json($user);
    }

    private function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        return is_array($data) ? $data : [];
    }

    private function validateRegistration(array $input): array
    {
        $errors = [];

        if (empty($input['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($input['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        if (empty($input['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($input['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        }

        if (empty($input['passwordConfirmation'])) {
            $errors['passwordConfirmation'] = 'Password confirmation is required';
        } elseif ($input['password'] !== $input['passwordConfirmation']) {
            $errors['passwordConfirmation'] = 'Passwords do not match';
        }

        return $errors;
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (strlen($data) % 4 ?: 4)));
    }
}
