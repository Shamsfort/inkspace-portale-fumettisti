<?php

namespace App\Database\Connectors;

use Illuminate\Database\Connectors\PostgresConnector;

class NeonPostgresConnector extends PostgresConnector
{
    protected function getDsn(array $config)
    {
        $dsn = parent::getDsn($config);
        $endpointId = $config['neon_endpoint'] ?? null;

        if (is_string($endpointId) && $endpointId !== '') {
            $dsn .= ";options='endpoint={$endpointId}'";
        }

        return $dsn;
    }
}

