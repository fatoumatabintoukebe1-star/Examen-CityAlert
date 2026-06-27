<?php
namespace App\Core;
use App\Exception\AccessDeniedException;

class Auth {
    public static function user(): ?array {
        return Session::get('user');
    }
    public static function isLoggedIn(): bool {
        return Session::has('user');
    }
    public static function role(): ?string {
        return self::user()['role'] ?? null;
    }
    public static function require(array $roles): void {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login'); exit;
        }
        if (!in_array(self::role(), $roles)) {
            throw new AccessDeniedException();
        }
    }
    public static function check(string $role): bool {
        return self::role() === $role;
    }
}