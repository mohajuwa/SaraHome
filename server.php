<?php

/**
 * Lightweight router for PHP's built-in server (php -S), used by START-SeraHome.bat.
 * This avoids `php artisan serve`, which is unreliable with the Herd php shim on
 * some Windows setups. Serves existing files from /public and routes the rest
 * through Laravel's front controller.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve real files in /public directly (assets, uploaded images, etc.).
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';
