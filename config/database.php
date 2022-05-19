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
        'igrcpg' => [
            'driver' => 'oracle',
            'host' => '192.168.226.191',
            'port' => '1521',
            'database' => 'IGRCPG',
            'username' => 'igrcpg',
            'password' => 'M1ghtyth0rcpg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsby' => [ //igrsby
            'driver' => 'oracle',
            'host' => '192.9.220.191',
            'port' => '1521',
            'database' => 'IGRSBY',
            'username' => 'IGRSBY',
            'password' => 'V1s10nsby!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbdg' => [ //igrbdg
            'driver' => 'oracle',
            'host' => '192.168.222.191',
            'port' => '1521',
            'database' => 'IGRBDG2',
            'username' => 'IGRbdg',
            'password' => 'Ind0gros1r2018',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrtgr' => [
            'driver' => 'oracle',
            'host' => '192.168.228.191',
            'port' => '1521',
            'database' => 'IGRTGR',
            'username' => 'IGRTGR',
            'password' => 'Gr34thulktgr!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrygy' => [
            'driver' => 'oracle',
            'host' => '192.168.224.191',
            'port' => '1521',
            'database' => 'IGRYGY',
            'username' => 'IGRYGY',
            'password' => 'Sp1d3rmanyog!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmdn' => [
            'driver' => 'oracle',
            'host' => '192.168.229.191',
            'port' => '1521',
            'database' => 'igrmdn',
            'username' => 'igrmdn',
            'password' => 'Sc4rl3tw1cmdn!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbks' => [
            'driver' => 'oracle',
            'host' => '192.168.225.191',
            'port' => '1521',
            'database' => 'igrbks',
            'username' => 'igrbks',
            'password' => '1r0nm4nbks!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrplg' => [
            'driver' => 'oracle',
            'host' => '192.168.232.191',
            'port' => '1521',
            'database' => 'IGRPLG',
            'username' => 'igrplg',
            'password' => 'V4lkyr13PLG!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrkmy' => [
            'driver' => 'oracle',
            'host' => '192.168.234.191',
            'port' => '1521',
            'database' => 'IGRKMY',
            'username' => 'igrkmy',
            'password' => 'C4ptus4kmy!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrpku' => [
            'driver' => 'oracle',
            'host' => '192.168.235.191',
            'port' => '1521',
            'database' => 'igrpku',
            'username' => 'igrpku',
            'password' => 'Bl4ckw1dowpku!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsmd' => [
            'driver' => 'oracle',
            'host' => '192.168.236.191',
            'port' => '1521',
            'database' => 'IGRSMD',
            'username' => 'igrsmd',
            'password' => 'Furrysmd!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrsmg' => [
            'driver' => 'oracle',
            'host' => '192.168.237.191',
            'port' => '1521',
            'database' => 'IGRSMG',
            'username' => 'igrsmg',
            'password' => 'H4wkey3smg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbgr' => [
            'driver' => 'oracle',
            'host' => '192.168.240.191',
            'port' => '1521',
            'database' => 'IGRBGR',
            'username' => 'igrbgr',
            'password' => '4ntm4nbgr!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrptk' => [
            'driver' => 'oracle',
            'host' => '192.168.238.191',
            'port' => '1521',
            'database' => 'IGRPTK',
            'username' => 'igrptk',
            'password' => 'Bp4nthptk!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbms' => [
            'driver' => 'oracle',
            'host' => '192.168.239.191',
            'port' => '1521',
            'database' => 'igrbms',
            'username' => 'igrbms',
            'password' => 'Drstr4ng3bms!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmdo' => [
            'driver' => 'oracle',
            'host' => '192.168.241.191',
            'port' => '1521',
            'database' => 'IGRMDO',
            'username' => 'IGRMDO',
            'password' => 'W0lfverin3mdo!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrgij' => [
            'driver' => 'oracle',
            'host' => '172.20.22.93',
            'port' => '1521',
            'database' => 'IGRCRM',
            'username' => 'IGRGIJ',
            'password' => 'St4rL0rdgib!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrjbi' => [
            'driver' => 'oracle',
            'host' => '192.168.242.191',
            'port' => '1521',
            'database' => 'IGRJBI',
            'username' => 'igrjbi',
            'password' => 'B4bygr0otjbi!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmks' => [
            'driver' => 'oracle',
            'host' => '192.168.243.191',
            'port' => '1521',
            'database' => 'IGRMKS',
            'username' => 'igrmks',
            'password' => 'C4pm4rv3lmks!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrkri' => [
            'driver' => 'oracle',
            'host' => '192.168.244.191',
            'port' => '1521',
            'database' => 'IGRKRI',
            'username' => 'igrkri',
            'password' => 'D4redev1lkri!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igramb' => [
            'driver' => 'oracle',
            'host' => '192.168.230.191',
            'port' => '1521',
            'database' => 'IGRamb',
            'username' => 'igramb',
            'password' => 'L0k1amb!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrcpt' => [
            'driver' => 'oracle',
            'host' => '192.168.245.191',
            'port' => '1521',
            'database' => 'IGRCPT',
            'username' => 'igrcpt',
            'password' => 'Slvsurf3rcpt!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrkrw' => [
            'driver' => 'oracle',
            'host' => '192.168.231.191',
            'port' => '1521',
            'database' => 'IGRKRW',
            'username' => 'IGRKRW',
            'password' => 'F4lc0nkrw!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrmlg' => [
            'driver' => 'oracle',
            'host' => '192.168.246.191',
            'port' => '1521',
            'database' => 'IGRMLG',
            'username' => 'igrmlg',
            'password' => 'G4m0r4mlg!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrbdl' => [
            'driver' => 'oracle',
            'host' => '192.168.247.191',
            'port' => '1521',
            'database' => 'IGRBDL',
            'username' => 'igrbdl',
            'password' => 'J4rv15bdl!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'igrslo' => [
            'driver' => 'oracle',
            'host' => '192.168.248.191',
            'port' => '1521',
            'database' => 'IGRSLO',
            'username' => 'igrslo',
            'password' => 'Ultr0nslo!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        //KONEKSI KE PUSAT
        'igrcrm' => [
            'driver' => 'oracle',
            'host' => '172.20.22.93',
            'port' => '1521',
            'database' => 'IGRCRM',
            'username' => 'IGRCRM',
            'password' => 'IGRCRM',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        // 'igrmktho' => [
        //     'driver' => 'oracle',
        //     'host' => '192.168.71.169',
        //     'port' => '1521',
        //     'database' => 'IGRMKTHO2',
        //     'username' => 'IGRCRM',
        //     'password' => 'IGRCRM',
        //     'charset' => 'AL32UTF8',
        //     'prefix' => '',
        // ],

        'igrckl' => [
            'driver' => 'oracle',
            'host' => '192.168.249.191',
            'port' => '1521',
            'database' => 'IGRCKL',
            'username' => 'IGRCKL',
            'password' => 'Sh4ngch1ckl!',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        //KONEKSI KE SIMULASI

        'simcpg' => [
            'driver' => 'oracle',
            'host' => '192.168.226.193',
            'port' => '1521',
            'database' => 'SIMCPG',
            'username' => 'SIMCPG',
            'password' => 'SIMCPG',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsby' => [
            'driver' => 'oracle',
            'host' => '192.9.220.193',
            'port' => '1521',
            'database' => 'SIMSBY',
            'username' => 'SIMSBY',
            'password' => 'SIMSBY',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbdg' => [
            'driver' => 'oracle',
            'host' => '192.168.222.193',
            'port' => '1521',
            'database' => 'SIMBDG',
            'username' => 'SIMBDG',
            'password' => 'SIMBDG',
            'charset' => 'AL32UTF8',
            'prefix' => '',
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

        'simygy' => [
            'driver' => 'oracle',
            'host' => '192.168.224.193',
            'port' => '1521',
            'database' => 'SIMIGRYGY',
            'username' => 'SIMYGY',
            'password' => 'SIMYGY',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simmdn' => [
            'driver' => 'oracle',
            'host' => '192.168.229.193',
            'port' => '1521',
            'database' => 'IGRMDNSIM',
            'username' => 'SIMMDN',
            'password' => 'SIMMDN',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbks' => [
            'driver' => 'oracle',
            'host' => '192.168.225.200',
            'port' => '1521',
            'database' => 'SIMBKS',
            'username' => 'SIMBKS',
            'password' => 'SIMBKS',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simplg' => [
            'driver' => 'oracle',
            'host' => '192.168.232.193',
            'port' => '1521',
            'database' => 'SIMPLG',
            'username' => 'SIMPLG',
            'password' => 'SIMPLG',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

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

        'simpku' => [
            'driver' => 'oracle',
            'host' => '192.168.235.193',
            'port' => '1521',
            'database' => 'SIMPKU',
            'username' => 'SIMPKU',
            'password' => 'SIMPKU',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simsmd' => [
            'driver' => 'oracle',
            'host' => '192.168.236.193',
            'port' => '1521',
            'database' => 'SIMSMD',
            'username' => 'SIMSMD',
            'password' => 'SIMSMD',
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

        'simbgr' => [
            'driver' => 'oracle',
            'host' => '192.168.240.193',
            'port' => '1521',
            'database' => 'SIMBGR',
            'username' => 'SIMBGR',
            'password' => 'SIMBGR',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simptk' => [
            'driver' => 'oracle',
            'host' => '192.168.238.193',
            'port' => '1521',
            'database' => 'SIMPTK',
            'username' => 'SIMPTK',
            'password' => 'SIMPTK',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbms' => [
            'driver' => 'oracle',
            'host' => '192.168.239.193',
            'port' => '1521',
            'database' => 'SIMBMS',
            'username' => 'SIMBMS',
            'password' => 'SIMBMS',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simmdo' => [
            'driver' => 'oracle',
            'host' => '192.168.241.193',
            'port' => '1521',
            'database' => 'SIMMDO',
            'username' => 'SIMMDO',
            'password' => 'SIMMDO',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simjbi' => [
            'driver' => 'oracle',
            'host' => '192.168.242.193',
            'port' => '1521',
            'database' => 'SIMJBI',
            'username' => 'SIMJBI',
            'password' => 'SIMJBI',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simmks' => [
            'driver' => 'oracle',
            'host' => '192.168.243.193',
            'port' => '1521',
            'database' => 'SIMMKS',
            'username' => 'SIMMKS',
            'password' => 'SIMMKS',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simkri' => [
            'driver' => 'oracle',
            'host' => '192.168.244.193',
            'port' => '1521',
            'database' => 'SIMKRI',
            'username' => 'SIMKRI',
            'password' => 'SIMKRI',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simamb' => [
            'driver' => 'oracle',
            'host' => '192.168.230.193',
            'port' => '1521',
            'database' => 'SIMAMB',
            'username' => 'SIMAMB',
            'password' => 'SIMAMB',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simcpt' => [
            'driver' => 'oracle',
            'host' => '192.168.245.193',
            'port' => '1521',
            'database' => 'SIMCPT',
            'username' => 'SIMCPT',
            'password' => 'SIMCPT',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simkrw' => [
            'driver' => 'oracle',
            'host' => '192.168.231.193',
            'port' => '1521',
            'database' => 'SIMKRW',
            'username' => 'SIMKRW',
            'password' => 'SIMKRW',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simmlg' => [
            'driver' => 'oracle',
            'host' => '192.168.246.193',
            'port' => '1521',
            'database' => 'SIMMLG',
            'username' => 'SIMMLG',
            'password' => 'SIMMLG',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simbdl' => [
            'driver' => 'oracle',
            'host' => '192.168.247.193',
            'port' => '1521',
            'database' => 'SIMBDL',
            'username' => 'SIMBDL',
            'password' => 'SIMBDL',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simslo' => [
            'driver' => 'oracle',
            'host' => '192.168.248.193',
            'port' => '1521',
            'database' => 'SIMSLO',
            'username' => 'SIMSLO',
            'password' => 'SIMSLO',
            'charset' => 'AL32UTF8',
            'prefix' => '',
        ],

        'simckl' => [
            'driver' => 'oracle',
            'host' => '192.168.249.193',
            'port' => '1521',
            'database' => 'SIMCKL',
            'username' => 'SIMCKL',
            'password' => 'SIMCKL',
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

        'pgigrbdl' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '192.168.3.175'),
            'port' => env('DB_PORT', '5444'),
            'database' => env('DB_DATABASE', 'igrbdl'),
            'username' => env('DB_USERNAME', 'igrbdl'),
            'password' => env('DB_PASSWORD', 'igrbdl'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'igrbdl',
            'sslmode' => 'prefer',
        ],

        'testpg' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'pgdb'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pg'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'logquery' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'pgdb'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pg'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'logquery',
            'sslmode' => 'prefer',
        ],

        'igrlocalhost' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'pgdb'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pg'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'igrlocalhost',
            'sslmode' => 'prefer',
        ],

        'ciputat' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'pgdb'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pg'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'ciputat',
            'sslmode' => 'prefer',
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

        //PASSWORD GENERATOR
        'dbsupport' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '172.31.16.55'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'postgres123'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'dbsupport',
            'sslmode' => 'prefer',
        ],

        'igrphi' => [
            'driver' => 'oracle',
            'host' => '192.168.234.193',
            'port' => '1521',
            'database' => 'simkmy',
            'username' => 'igrphi',
            'password' => 'igrphi123',
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
