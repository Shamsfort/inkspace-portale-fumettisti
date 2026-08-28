<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

$storagePath = '/tmp/storage';
$bootstrapCachePath = '/tmp/bootstrap/cache';

foreach ([
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
    $bootstrapCachePath,
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

$databasePath = '/tmp/inkspace.sqlite';

if (! file_exists($databasePath)) {
    copy(__DIR__.'/../database/database.sqlite', $databasePath);
}

$defaults = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'APP_CONFIG_CACHE' => $bootstrapCachePath.'/config.php',
    'APP_EVENTS_CACHE' => $bootstrapCachePath.'/events.php',
    'APP_PACKAGES_CACHE' => $bootstrapCachePath.'/packages.php',
    'APP_ROUTES_CACHE' => $bootstrapCachePath.'/routes-v7.php',
    'APP_SERVICES_CACHE' => $bootstrapCachePath.'/services.php',
    'LOG_CHANNEL' => 'stderr',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $databasePath,
    'CACHE_DRIVER' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'FILESYSTEM_DISK' => 'local',
    'VIEW_COMPILED_PATH' => $storagePath.'/framework/views',
];

foreach ($defaults as $name => $value) {
    if (getenv($name) === false) {
        putenv($name.'='.$value);
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

require __DIR__.'/../public/index.php';
