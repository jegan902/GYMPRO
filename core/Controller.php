<?php
/**
 * Base Controller Class
 * Provides helper methods for loading models and views
 */
class Controller
{
    /**
     * Load a model
     * @param string $model  Model class name (e.g. 'UserModel')
     * @return object
     */
    protected function model($model)
    {
        $modelFile = APP_ROOT . '/app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        die("Model {$model} not found.");
    }

    /**
     * Load a view with data
     * @param string $view  View path (e.g. 'auth/login')
     * @param array  $data  Data to pass to view
     */
    protected function view($view, $data = [])
    {
        $viewFile = APP_ROOT . '/app/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            extract($data);
            // Allow views to use $this->view for nested includes
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();

            // If layout exists, wrap content in layout
            $layoutFile = APP_ROOT . '/app/views/layouts/main.php';
            if (file_exists($layoutFile) && !isset($data['no_layout'])) {
                require_once $layoutFile;
            } else {
                echo $content;
            }
        } else {
            die("View {$view} not found.");
        }
    }

    /**
     * Redirect helper
     */
    protected function redirect($url)
    {
        header('Location: ' . URL_ROOT . '/' . $url);
        exit;
    }

    /**
     * JSON response helper
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Validate CSRF token from POST
     */
    protected function validateCSRF()
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!Session::validateCSRF($token)) {
            Session::flash('error', 'Token bảo mật không hợp lệ. Vui lòng thử lại.', 'danger');
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? URL_ROOT);
            exit;
        }
    }

    /**
     * Sanitize input
     */
    protected function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}
