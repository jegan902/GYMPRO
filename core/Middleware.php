<?php
/**
 * Middleware Class
 * Handles authentication and role-based authorization
 */
class Middleware
{
    /**
     * Require user to be logged in
     */
    public static function requireAuth()
    {
        if (!Session::isLoggedIn()) {
            Session::flash('error', 'Vui lòng đăng nhập để tiếp tục.', 'danger');
            header('Location: ' . URL_ROOT . '/auth/login');
            exit;
        }
    }

    /**
     * Require specific role(s)
     * @param string|array $roles  e.g. 'admin' or ['admin', 'staff']
     */
    public static function requireRole($roles)
    {
        self::requireAuth();

        if (is_string($roles)) {
            $roles = [$roles];
        }

        if (!in_array(Session::userRole(), $roles)) {
            Session::flash('error', 'Bạn không có quyền truy cập trang này.', 'danger');
            header('Location: ' . URL_ROOT . '/dashboard');
            exit;
        }
    }

    /**
     * Redirect if already logged in
     */
    public static function guest()
    {
        if (Session::isLoggedIn()) {
            header('Location: ' . URL_ROOT . '/dashboard');
            exit;
        }
    }
}
