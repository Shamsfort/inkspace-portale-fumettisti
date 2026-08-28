<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class MediaStorage
{
    private const BLOB_API_URL = 'https://vercel.com/api/blob';

    public function store(UploadedFile $file, string $directory): string
    {
        if (! $this->usesVercelBlob()) {
            return $file->store($directory, 'public');
        }

        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';
        $pathname = trim($directory, '/').'/'.Str::uuid().'.'.$extension;
        $stream = fopen($file->getRealPath(), 'rb');

        if ($stream === false) {
            throw new RuntimeException('Impossibile leggere il file caricato.');
        }

        try {
            $response = $this->client()->request('PUT', self::BLOB_API_URL.'/?'.http_build_query([
                'pathname' => $pathname,
            ]), [
                'headers' => $this->headers([
                    'x-vercel-blob-access' => 'public',
                    'x-content-type' => $file->getMimeType() ?: 'application/octet-stream',
                    'x-add-random-suffix' => '0',
                    'x-cache-control-max-age' => '31536000',
                ]),
                'body' => $stream,
            ]);
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }

        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        if (! isset($payload['url']) || ! is_string($payload['url'])) {
            throw new RuntimeException('Vercel Blob non ha restituito un URL valido.');
        }

        return $payload['url'];
    }

    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        if (! $this->isRemote($path)) {
            Storage::disk('public')->delete($path);

            return;
        }

        if (! $this->usesVercelBlob() || ! Str::contains($path, '.blob.vercel-storage.com/')) {
            return;
        }

        try {
            $this->client()->request('POST', self::BLOB_API_URL.'/delete', [
                'headers' => $this->headers(['content-type' => 'application/json']),
                'json' => ['urls' => [$path]],
            ]);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    public function url(?string $path): ?string
    {
        if (! $path || $this->isRemote($path)) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function usesVercelBlob(): bool
    {
        return filled(env('BLOB_READ_WRITE_TOKEN')) && filled(env('BLOB_STORE_ID'));
    }

    private function isRemote(string $path): bool
    {
        return Str::startsWith($path, ['https://', 'http://']);
    }

    private function client(): Client
    {
        return new Client([
            'connect_timeout' => 10,
            'timeout' => 30,
            'http_errors' => true,
        ]);
    }

    private function headers(array $additional = []): array
    {
        $storeId = (string) env('BLOB_STORE_ID');

        return array_merge([
            'authorization' => 'Bearer '.env('BLOB_READ_WRITE_TOKEN'),
            'x-api-version' => '12',
            'x-api-blob-request-id' => $storeId.':'.(int) (microtime(true) * 1000).':'.bin2hex(random_bytes(8)),
            'x-vercel-blob-store-id' => $storeId,
            'x-api-blob-request-attempt' => '0',
        ], $additional);
    }
}

