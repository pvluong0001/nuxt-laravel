<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;

class SqlLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerSqlLogger();
    }

    private function registerSqlLogger()
    {
        $id = uniqid();
        \DB::listen(
            function (QueryExecuted $queryExecuted) use ($id) {
                $query = $queryExecuted->sql;
                $bindings = $queryExecuted->bindings;
                $time = $queryExecuted->time;
                $connection = $queryExecuted->connection;
                $databaseName = $connection->getDatabaseName();

                // Format binding data for sql insertion
                foreach ($bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } elseif (is_string($binding)) {
                        $bindings[$i] = "'$binding'";
                    }
                }

                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
                $query = vsprintf($query, $bindings);
                $message = "$id-$databaseName [{$time}ms] $query";

                \Log::channel('sql')->debug($message);
            }
        );
    }
}
