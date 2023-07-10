<?php

namespace App\Infrastructure\Persistence;

use Illuminate\Database\Capsule\Manager as Capsule;

class SQLiteConnection
{
    public static function connect()
    {
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/../../../database.sqlite.sqlite3',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
