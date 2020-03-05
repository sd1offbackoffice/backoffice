<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'simsmg'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'as'),
            'username' => env('DB_USERNAME', 'foruuge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],


        // KONEKSI KE CABANG
        'igrCPG' => [
            'driver' => 'oracle',
            'host' => '192.168.226.191',
            'port' => '1521',
            'database' => 'IGRCPG',
            'username' => 'igrcpg',
            'password' => 'M1ghtyth0rcpg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrSBY' => [ //igrsby
            'driver' => 'oracle',
            'host' => '192.9.220.192',
            'port' => '1521',
            'database' => 'IGRSBY2',
            'username' => 'IGRSBY',
            'password' => 'V1s10nsby!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrBDG' => [ //igrbdg
            'driver' => 'oracle',
            'host' => '192.168.222.191',
            'port' => '1521',
            'database' => 'IGRBDG',
            'username' => 'IGRbdg',
            'password' => 'Ind0gros1r2018',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrTGR' => [
            'driver' => 'oracle',
            'host' => '192.168.228.191',
            'port' => '1521',
            'database' => 'IGRTGR',
            'username' => 'IGRTGR',
            'password' => 'Gr34thulktgr!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrYGY' => [
            'driver' => 'oracle',
            'host' => '192.168.224.191',
            'port' => '1521',
            'database' => 'IGRYGY',
            'username' => 'IGRYGY',
            'password' => 'Sp1d3rmanyog!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrMDN' => [
            'driver' => 'oracle',
            'host' => '192.168.229.192',
            'port' => '1521',
            'database' => 'igrmdn2',
            'username' => 'igrmdn',
            'password' => 'Sc4rl3tw1cmdn!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrBKS' => [
            'driver' => 'oracle',
            'host' => '192.168.225.191',
            'port' => '1521',
            'database' => 'igrbks',
            'username' => 'igrbks',
            'password' => '1r0nm4nbks!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrPLG' => [
            'driver' => 'oracle',
            'host' => '192.168.232.192',
            'port' => '1521',
            'database' => 'IGRPLG2',
            'username' => 'igrplg',
            'password' => 'V4lkyr13PLG!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrKMY' => [
            'driver' => 'oracle',
            'host' => '192.168.234.191',
            'port' => '1521',
            'database' => 'IGRKMY',
            'username' => 'igrkmy',
            'password' => 'C4ptus4kmy!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrSMD' => [
            'driver' => 'oracle',
            'host' => '192.168.236.192',
            'port' => '1521',
            'database' => 'IGRSMD2',
            'username' => 'igrsmd',
            'password' => 'Furrysmd!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrSMG' => [
            'driver' => 'oracle',
            'host' => '192.168.237.191',
            'port' => '1521',
            'database' => 'IGRSMG',
            'username' => 'igrsmg',
            'password' => 'H4wkey3smg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrPTK' => [
            'driver' => 'oracle',
            'host' => '192.168.238.191',
            'port' => '1521',
            'database' => 'IGRPTK',
            'username' => 'igrptk',
            'password' => 'Bp4nthptk!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrBGR' => [
            'driver' => 'oracle',
            'host' => '192.168.240.191',
            'port' => '1521',
            'database' => 'IGRBGR',
            'username' => 'igrbgr',
            'password' => '4ntm4nbgr!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrPKU' => [
            'driver' => 'oracle',
            'host' => '192.168.235.191',
            'port' => '1521',
            'database' => 'igrpku',
            'username' => 'igrpku',
            'password' => 'Bl4ckw1dowpku!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrBMS' => [
            'driver' => 'oracle',
            'host' => '192.168.239.192',
            'port' => '1521',
            'database' => 'igrbms2',
            'username' => 'igrbms',
            'password' => 'Drstr4ng3bms!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrMDO' => [
            'driver' => 'oracle',
            'host' => '192.168.241.191',
            'port' => '1521',
            'database' => 'IGRMDO',
            'username' => 'IGRMDO',
            'password' => 'W0lfverin3mdo!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrMKS' => [
            'driver' => 'oracle',
            'host' => '192.168.243.191',
            'port' => '1521',
            'database' => 'IGRMKS',
            'username' => 'igrmks',
            'password' => 'C4pm4rv3lmks!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrJBI' => [
            'driver' => 'oracle',
            'host' => '192.168.242.191',
            'port' => '1521',
            'database' => 'IGRJBI',
            'username' => 'igrjbi',
            'password' => 'B4bygr0otjbi!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrKRI' => [
            'driver' => 'oracle',
            'host' => '192.168.244.191',
            'port' => '1521',
            'database' => 'IGRKRI',
            'username' => 'igrkri',
            'password' => 'D4redev1lkri!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrAMB' => [
            'driver' => 'oracle',
            'host' => '192.168.230.191',
            'port' => '1521',
            'database' => 'IGRamb',
            'username' => 'igramb',
            'password' => 'L0k1amb!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrCPT' => [
            'driver' => 'oracle',
            'host' => '192.168.245.191',
            'port' => '1521',
            'database' => 'IGRCPT',
            'username' => 'igrcpt',
            'password' => 'Slvsurf3rcpt!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrKRW' => [
            'driver' => 'oracle',
            'host' => '192.168.231.191',
            'port' => '1521',
            'database' => 'IGRKRW',
            'username' => 'IGRKRW',
            'password' => 'F4lc0nkrw!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrMLG' => [
            'driver' => 'oracle',
            'host' => '192.168.246.191',
            'port' => '1521',
            'database' => 'IGRMLG',
            'username' => 'igrmlg',
            'password' => 'G4m0r4mlg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrBDL' => [
            'driver' => 'oracle',
            'host' => '192.168.247.191',
            'port' => '1521',
            'database' => 'IGRBDL',
            'username' => 'igrbdl',
            'password' => 'igrbdl',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],


        //KONEKSI KE PUSAT
        'igrcrm' => [
            'driver' => 'oracle',
            'host' => '192.168.10.42',
            'port' => '1521',
            'database' => 'IGRCRM',
            'username' => 'IGRCRM',
            'password' => 'IGRCRM',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmktho' => [
            'driver' => 'oracle',
            'host' => '192.168.71.169',
            'port' => '1521',
            'database' => 'IGRMKTHO2',
            'username' => 'IGRCRM',
            'password' => 'IGRCRM',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsimkrw' => [
            'driver' => 'oracle',
            'host' => '192.168.231.193',
            'port' => '1521',
            'database' => 'SIMKRW',
            'username' => 'SIMKRW',
            'password' => 'SIMKRW',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        //KONEKSI KE SIMULASI

        'simkmy' => [
            'driver' => 'oracle',
            'host' => '192.168.234.193',
            'port' => '1521',
            'database' => 'SIMKMY',
            'username' => 'SIMKMY',
            'password' => 'SIMKMY',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsmg' => [
            'driver' => 'oracle',
            'host' => '192.168.237.193',
            'port' => '1521',
            'database' => 'SIMSMG',
            'username' => 'SIMSMG',
            'password' => 'SIMSMG',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsimi2' => [
            'driver' => 'pgsql',
            'host' => '192.168.3.175',
            'port' => '5444',
            'database' => 'postgres',
            'username' => 'enterprisedb',
            'password' => 'pgoracle',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsimi' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '192.168.3.175'),
            'port' => env('DB_PORT', '5444'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'enterprisedb'),
            'password' => env('DB_PASSWORD', 'pgoracle'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'simtgr' => [
            'driver' => 'oracle',
            'host' => '192.168.228.193',
            'port' => '1521',
            'database' => 'SIMTGR',
            'username' => 'SIMTGR',
            'password' => 'SIMTGR',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'predis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],

];
