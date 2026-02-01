<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Check vendor
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die("Vendor autoload missing! Composer did not run.");
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

try {
    // Bootstrap Laravel and handle the request...
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // === VERCEL FIX: Use /tmp for storage because Vercel is Read-Only ===
    $app->useStoragePath('/tmp');

    // Redirect bootstrap cache files to /tmp
    $_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
    $_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
    $_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
    $_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
    $_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

    // Clear config cache to prevent stale paths from breaking "View"
    $app->make('Illuminate\Contracts\Console\Kernel')->call('config:clear');

    // Override View Compiled Path to /tmp
    $app['config']->set('view.compiled', '/tmp/views');
    // ====================================================================

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Error 500 Debug</h1>";
    echo "<h2>" . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
