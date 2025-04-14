<?php

namespace App\Providers;

// use App\Database\Connections\CustomConnection;

use App\Connections\CustomConnection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Grammars\PostgresGrammar;
use Illuminate\Database\Schema\Grammars\PostgresGrammar as GrammarsPostgresGrammar;
use Illuminate\Support\ServiceProvider;

class CustomDataBaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('db', function ($app) {
            $dbm = new DatabaseManager($app, $app['db.factory']);
            $dbm->extend('pgsql', function ($config, $name) use ($app) {
                $connection = $app['db.factory']->make($config, $name);
                $new_connection = new CustomConnection(
                    $connection->getPdo(),
                    $connection->getDatabaseName(),
                    $connection->getTablePrefix(),
                    $config
                );
                $new_connection->setQueryGrammar(new PostgresGrammar);
                $new_connection->setSchemaGrammar(new GrammarsPostgresGrammar);

                return $new_connection;
            });
            return $dbm;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
