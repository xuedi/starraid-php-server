<?php
$root = realpath(dirname(__FILE__) . '/../..');
$json = file_get_contents($root . '/config/config.json');
$data = json_decode($json, true) ?? [];

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'default',
        'default' => [
            'adapter' => 'mysql',
            'host' => $data['database']['host'] ?? null,
            'name' => $data['database']['name'] ?? null,
            'user' => $data['database']['user'] ?? null,
            'pass' => $data['database']['pass'] ?? null,
            'port' => $data['database']['port'] ?? null,
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
