<?php
namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTHandler {
    private static $secret_key = "a_very_long_and_secure_secret_key_for_jwt_2026"; // >= 32 characters
    private static $algorithm = 'HS256';

    public static function generateToken($data) {
        $issuedAt = time();
        $expire = $issuedAt + (60 * 60); // Token hết hạn sau 1 giờ

        $payload = [
            'iat'  => $issuedAt,
            'exp'  => $expire,
            'data' => $data
        ];

        return JWT::encode($payload, self::$secret_key, self::$algorithm);
    }

    public static function decodeToken($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, self::$algorithm));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
}
