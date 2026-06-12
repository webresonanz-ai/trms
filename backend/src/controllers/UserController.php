<?php

declare(strict_types=1);

namespace TRMS\Controllers;

use TRMS\Core\Response;
use TRMS\Middleware\Auth;
use TRMS\Models\User;

class UserController
{
    public function profile(): void
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

    public function updateProfile(): void
    {
        Auth::handle();

        $payload = Auth::getPayloadFromHeader();

        if (!$payload || !isset($payload['sub'])) {
            Response::error('Invalid token', 401);
        }

        $input = $this->getJsonInput();
        $errors = $this->validate($input);

        if ($errors) {
            Response::validationError($errors);
        }

        $userModel = new User();
        $userId = (int) $payload['sub'];

        $userModel->updateProfile($userId, $input);
        $user = $userModel->find('users', $userId);
        unset($user['password']);

        Response::success('Profile updated successfully', $user);
    }

    private function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        return is_array($data) ? $data : [];
    }

    private function validate(array $input): array
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

        if (!empty($input['phone']) && !preg_match('/^[+]?[\d\s()-]+$/', $input['phone'])) {
            $errors['phone'] = 'Invalid phone number';
        }

        return $errors;
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (strlen($data) % 4 ?: 4)));
    }
}
