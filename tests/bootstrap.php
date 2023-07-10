<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Persistence\SQLiteConnection;

// Configurar a conexão com o banco de dados de teste
SQLiteConnection::connect();
