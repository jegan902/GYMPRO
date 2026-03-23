<?php
/**
 * Session Class
 * Manages sessions, flash messages, and CSRF tokens
 */
class Session
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Session timeout check
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
                self::destroy();
                header('Location: ' . URL_ROOT . '/auth/login');
                exit;
            }
        }
        $_SESSION['last_activity'] = time();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
    }

    // ── Flash Messages ──
    public static function flash($key, $message = '', $type = 'info')
    {
        if (!empty($message)) {
            $_SESSION['flash'][$key] = [
                'message' => $message,
                'type'    => $type
            ];
        } elseif (isset($_SESSION['flash'][$key])) {
            $flash = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
        return null;
    }

    public static function hasFlash($key)
    {
        return isset($_SESSION['flash'][$key]);
    }

    // ── CSRF Token ──
    public static function generateCSRF()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        return $token;
    }

    public static function getCSRF()
    {
        if (!isset($_SESSION['csrf_token'])) {
            return self::generateCSRF();
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRF($token)
    {
        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
            // Regenerate token after validation
            self::generateCSRF();
            return true;
        }
        return false;
    }

    // ── Auth Helpers ──
    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public static function userId()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function userRole()
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function userName()
    {
        return $_SESSION['user_name'] ?? null;
    }
}
