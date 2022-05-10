<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        // Kingsley
        'receipts' => [
            'driver' => 'local',
            'root'   => '../storage/receipts/',
        ],

        // Kingsley
        'signature_expedition' => [
            'driver' => 'local',
            'root'   => '../storage/signature_expedition/',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        // Kingsley
        'custom-ftp' => [
            'driver' => 'ftp',
            'host' => '172.20.28.18',
            'username' => 'btbigr',
            'password' => 'xxbtbigrxx',
            // Optional FTP Settings...
            // 'port'     => 21,
            // 'root' => '/opt/btbigr/temp/',
            // 'passive'  => true,
            // 'ssl'      => true,
            // 'timeout'  => 30,
        ],

        'DBF' => [
            'driver' => 'local',
            //            'root' => public_path() . '/DBF', //DIganti oleh JR 21/01/2022 karena error ketika write file ke folder DBF
            'root' => public_path() . '\DBF',
            'visibility' => 'public',
        ],

        'ftp' => [
            'driver' => 'ftp',
            'host' => '172.20.12.31',
            'port' => '26001',
            'username' => 'allsdeis',
            'password' => 'all5deis@17',
            'root' => '/ICC'
        ],

    ],

];
