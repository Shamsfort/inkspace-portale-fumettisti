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

$unpooledDatabaseUrl = getenv('DATABASE_URL_UNPOOLED');
$databaseUrl = is_string($unpooledDatabaseUrl) && $unpooledDatabaseUrl !== ''
    ? $unpooledDatabaseUrl
    : getenv('DATABASE_URL');
$usesPostgres = is_string($databaseUrl) && $databaseUrl !== '';

if ($usesPostgres) {
    putenv('DATABASE_URL='.$databaseUrl);
    $_ENV['DATABASE_URL'] = $databaseUrl;
    $_SERVER['DATABASE_URL'] = $databaseUrl;

    $databaseHost = parse_url($databaseUrl, PHP_URL_HOST);
    if (is_string($databaseHost)
        && str_ends_with($databaseHost, '.neon.tech')) {
        $endpointId = explode('.', $databaseHost)[0];
        putenv('NEON_ENDPOINT_ID='.$endpointId);
        $_ENV['NEON_ENDPOINT_ID'] = $endpointId;
        $_SERVER['NEON_ENDPOINT_ID'] = $endpointId;
    }
}

$databasePath = '/tmp/inkspace.sqlite';

if (! $usesPostgres && ! file_exists($databasePath)) {
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
    'DB_CONNECTION' => $usesPostgres ? 'pgsql' : 'sqlite',
    'CACHE_DRIVER' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'FILESYSTEM_DISK' => 'local',
    'VIEW_COMPILED_PATH' => $storagePath.'/framework/views',
];

if (! $usesPostgres) {
    $defaults['DB_DATABASE'] = $databasePath;
}

foreach ($defaults as $name => $value) {
    if (getenv($name) === false) {
        putenv($name.'='.$value);
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

if ($usesPostgres) {
    try {
        $console = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $console->bootstrap();
        $database = $app->make(Illuminate\Database\DatabaseManager::class);
        $schema = $database->connection()->getSchemaBuilder();
        $isInitialized = $schema->hasTable('migrations')
            && $database->table('migrations')
                ->where('migration', '2026_08_27_000001_create_profiles_and_comic_relations')
                ->exists();

        if (! $isInitialized) {
            $hasEmptyPartialSchema = $schema->hasTable('users')
                && ! $schema->hasTable('articles')
                && $database->table('users')->count() === 0;

            if ($hasEmptyPartialSchema) {
                $console->call('migrate:fresh', ['--force' => true]);
            } else {
                $console->call('migrate', ['--force' => true]);
            }

            if ($database->table('categories')->count() === 0) {
                $console->call('db:seed', ['--force' => true]);
            }
        }
    } catch (Throwable $exception) {
        error_log('Database initialization failed: '.$exception->getMessage());
    }
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();
$kernel->terminate($request, $response);

