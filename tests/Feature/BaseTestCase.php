<?php

namespace PrinceJohn\LaravelConfigBuilder\Test\Feature;

use Orchestra\Testbench\TestCase;
use PrinceJohn\LaravelConfigBuilder\ServiceProvider;

class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
