<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';
    public array $default;
    public array $tests;

    public function __construct()
    {
        parent::__construct();

        $this->default = [
            'DSN'      => '',
            'hostname' => $_ENV['database.default.hostname'] ?? 'localhost',
            'username' => $_ENV['database.default.username'] ?? 'root',
            'password' => $_ENV['database.default.password'] ?? '',
            'database' => $_ENV['database.default.database'] ?? '',
            'DBDriver' => $_ENV['database.default.DBDriver'] ?? 'MySQLi',
            'DBPrefix' => $_ENV['database.default.DBPrefix'] ?? '',
            'pConnect' => false,
            'DBDebug'  => filter_var($_ENV['database.default.DBDebug'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'cacheOn'  => false,
            'cacheDir' => '',
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => (int) ($_ENV['database.default.port'] ?? 3306),
        ];

        $this->tests = [
            'DSN'         => '',
            'hostname'    => '127.0.0.1',
            'username'    => '',
            'password'    => '',
            'database'    => ':memory:',
            'DBDriver'    => 'SQLite3',
            'DBPrefix'    => 'db_',
            'pConnect'    => false,
            'DBDebug'     => true,
            'cacheOn'     => false,
            'cacheDir'    => '',
            'charset'     => 'utf8',
            'DBCollat'    => '',
            'swapPre'     => '',
            'encrypt'     => false,
            'compress'    => false,
            'strictOn'    => false,
            'failover'    => [],
            'port'        => 3306,
            'foreignKeys' => true,
            'busyTimeout' => 1000,
        ];

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
