<?php
/**
 * Entry Point
 * Loads config, core classes, initializes session, and starts the App router
 */

// Load config
require_once '../config/config.php';

// Autoload core classes
$coreFiles = ['Database', 'Model', 'Controller', 'Session', 'Middleware', 'App'];
foreach ($coreFiles as $file) {
    require_once APP_ROOT . '/core/' . $file . '.php';
}

// Initialize session
Session::init();

// Start the app
$app = new App();
