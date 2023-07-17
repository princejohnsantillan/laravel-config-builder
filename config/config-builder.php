<?php

return [    
    'config-path' => config_path('/'),

    'class-path' => app_path('Config/'),

    'class-namespace' => 'App\\Config',

    'stub-path' => __DIR__.'/../stubs/',

    'lint-command' => base_path().'/vendor/bin/pint '.app_path('Config/').' --preset=laravel',
];
