<?php

namespace App\Config;

class ConfigBuilder
{
    public string $stub_path;

    public string $config_path;

    public string $class_path;

    public string $class_namespace;

    public string $pint_options;

    public function __construct()
    {

        $this->stub_path = '/Users/prince/code/princejohnsantillan/laravel-config-builder/config/../stubs/';

        $this->config_path = '/Users/prince/code/princejohnsantillan/laravel-config-builder/config/';

        $this->class_path = '/Users/prince/code/princejohnsantillan/laravel-config-builder/config/objects/';

        $this->class_namespace = 'App\\Config';

        $this->pint_options = '--preset=laravel';
    }

    public static function config()
    {
        return new self;
    }
}
