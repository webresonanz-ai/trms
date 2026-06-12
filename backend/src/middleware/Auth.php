<?php

declare(strict_types=1);

namespace TRMS\Middleware;

class Auth
{
    public static function handle(?callable $next = null): void
    {
        $payload = self::getPayloadFromHeader();

        if (!$payload) {
            \TRMS\Core\Response::error('Invalid or expired token', 401);
        }

        if ($next) {
            $next($payload);
        }
    }

    public static function getPayloadFromHeader(): ?array
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (empty($authHeader) || stripos($authHeader, 'Bearer ') !== 0) {
            return null;
        }

        $token = trim(substr($authHeader, 7));
        return self::verifyToken($token);
    }

    private static function verifyToken(string $token): ?array
    {
        $secret = getenv('JWT_SECRET') ?: 'your-jwt-secret-key-change-in-production';
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        [$headerB64, $payloadB64, $signature] = $parts;

        $expectedSig = self::base64UrlEncode(hash_hmac('sha256', "{$headerB64}.{$payloadB64}", $secret, true));

        if (!hash_equals($expectedSig, $signature)) {
            return null;
        }

        $payload = json_decode(self::base64UrlDecode($payloadB64), true);

        if (!$payload || !isset($payload['exp']) || time() > $payload['exp']) {
            return null;
        }

        return $payload;
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (strlen($data) % 4 ?: 4)));
    }

    public static function generateToken(array $userData): string
    {
        $secret = getenv('JWT_SECRET') ?: 'your-jwt-secret-key-change-in-production';

        $header = self::base64UrlEncode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));

        $payload = [
            'sub' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => $userData['role'],
            'iat' => time(),
            'exp' => time() + 86400,
        ];

        $payloadEncoded = self::base64UrlEncode(json_encode($payload));
        $signature = self::base64UrlEncode(
            hash_hmac('sha256', "{$header}.{$payloadEncoded}", $secret, true)
        );

        return "{$header}.{$payloadEncoded}.{$signature}";
    }
}
