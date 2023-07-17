<?php

namespace SolgenPower\{PackageName}\Test\Feature;

use Orchestra\Testbench\TestCase;
use SolgenPower\{PackageName}\ServiceProvider;

class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
