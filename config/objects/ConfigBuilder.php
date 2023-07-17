<?php

namespace App\Config;

class ConfigBuilder
{
    public string $stub_path;

    public string $config_path;

    public string $class_path;

    public string $class_namespace;

    public $pint_config;

    public function __construct()
    {

        $this->stub_path = '/Users/prince/code/princejohnsantillan/laravel-config-objectifier/config/../stubs/';

        $this->config_path = '/Users/prince/code/princejohnsantillan/laravel-config-objectifier/config/';

        $this->class_path = '/Users/prince/code/princejohnsantillan/laravel-config-objectifier/config/objects/';

        $this->class_namespace = 'App\\Config';

        $this->pint_config = null;
    }

    public static function config()
    {
        return new self;
    }
}
