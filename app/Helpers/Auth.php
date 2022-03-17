<?php

namespace App\Helpers;

class Auth
{
    public static function isAuthenticated(): bool {
        global $_SESSION;

        return isset($_SESSION['id']);
    }

    public static function isOwner($id): bool {
        global $_SESSION;

        return isset($_SESSION['id']) && $_SESSION['id'] == $id;
    }

    public static function setSession(array $data) {
        foreach ($data as $key=>$value) {
            $_SESSION[$key] = $value;
        }
    }

    public static function clearSession() {
        session_unset();
    }

    public static function get($key): mixed {
        if (Auth::isAuthenticated()) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
            return null;
        }
        return null;
    }
}