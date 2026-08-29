<?php

declare(strict_types=1);

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');

$storagePath = '/tmp/storage';

foreach ([
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0755, true);
    }
}

$shouldRunMigrations = filter_var(
    getenv('RUN_DATABASE_MIGRATIONS') ?: 'false',
    FILTER_VALIDATE_BOOLEAN
);
$pooledDatabaseUrl = getenv('DATABASE_URL');
$unpooledDatabaseUrl = getenv('DATABASE_URL_UNPOOLED');
$databaseUrl = $shouldRunMigrations
    && is_string($unpooledDatabaseUrl)
    && $unpooledDatabaseUrl !== ''
        ? $unpooledDatabaseUrl
        : $pooledDatabaseUrl;

if (! is_string($databaseUrl) || $databaseUrl === '') {
    $databaseUrl = $unpooledDatabaseUrl;
}

if ($shouldRunMigrations && (! is_string($unpooledDatabaseUrl) || $unpooledDatabaseUrl === '')) {
    throw new RuntimeException('DATABASE_URL_UNPOOLED is required while RUN_DATABASE_MIGRATIONS is enabled.');
}

if (getenv('VERCEL') && (! is_string($databaseUrl) || $databaseUrl === '')) {
    throw new RuntimeException('A persistent DATABASE_URL is required on Vercel.');
}

$usesPostgres = is_string($databaseUrl) && $databaseUrl !== '';

if ($usesPostgres) {
    putenv('DATABASE_URL='.$databaseUrl);
    $_ENV['DATABASE_URL'] = $databaseUrl;
    $_SERVER['DATABASE_URL'] = $databaseUrl;

    $databaseHost = parse_url($databaseUrl, PHP_URL_HOST);
    if (is_string($databaseHost)
        && str_ends_with($databaseHost, '.neon.tech')) {
        $endpointId = preg_replace('/-pooler$/', '', explode('.', $databaseHost)[0]);
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

if ($usesPostgres && $shouldRunMigrations) {
    $database = null;

    try {
        $console = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $console->bootstrap();
        $database = $app->make(Illuminate\Database\DatabaseManager::class);
        $database->statement('SELECT pg_advisory_lock(141029082026)');
        $exitCode = $console->call('migrate', ['--force' => true]);

        if ($exitCode !== 0) {
            throw new RuntimeException('Laravel migrate returned exit code '.$exitCode.'.');
        }

        if ($database->table('categories')->count() === 0) {
            $console->call('db:seed', ['--force' => true]);
        }
    } catch (Throwable $exception) {
        error_log('Database initialization failed: '.$exception->getMessage());
        throw $exception;
    } finally {
        if ($database !== null) {
            try {
                $database->statement('SELECT pg_advisory_unlock(141029082026)');
            } catch (Throwable $unlockException) {
                error_log('Database migration lock release failed: '.$unlockException->getMessage());
            }
        }
    }
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();
$kernel->terminate($request, $response);

