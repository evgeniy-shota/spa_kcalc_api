<?php

namespace App\Connections;

// use App\Builders\CustomDbBuilder;
// use Illuminate\Database\Connection;

use App\Builders\CustomDbBuilder;
use Illuminate\Database\PostgresConnection;

class CustomConnection extends PostgresConnection
{
    public function query()
    {
        return new CustomDbBuilder(
            $this,
            $this->getQueryGrammar(),
            $this->getPostProcessor()
        );
    }
}
