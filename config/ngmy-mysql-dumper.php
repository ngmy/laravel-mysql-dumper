<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Dump Setting Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the dump settings below you wish to use as
    | your default setting.
    |
    */

    'default' => 'all',

    /*
    |--------------------------------------------------------------------------
    | Dump Settings
    |--------------------------------------------------------------------------
    |
    | Here are each of the dump settings. Of course, you can also add
    | your own dump settings.
    |
    | The options that can be specified for the "dump_options" option are
    | listed here:
    | https://github.com/ifsnop/mysqldump-php#dump-settings
    |
    */

    'settings' => [

        'all' => [
            'connection' => 'mysql',
            'result_file' => \database_path('all.sql'),
            'imortable_with_laravel' => false,
            'dump_options' => [
                'exclude-tables' => [
                    'migrations',
                ],
            ],
        ],

        'data' => [
            'connection' => 'mysql',
            'result_file' => \database_path('data.sql'),
            'imortable_with_laravel' => false,
            'dump_options' => [
                'exclude-tables' => [
                    'migrations',
                ],
                'no-create-info' => true,
                'skip-triggers' => true,
            ],
        ],

        'schema' => [
            'connection' => 'mysql',
            'result_file' => \database_path('schema.sql'),
            'imortable_with_laravel' => false,
            'dump_options' => [
                'exclude-tables' => [
                    'migrations',
                ],
                'no-data' => true,
                'routines' => true,
            ],
        ],

    ],

];
