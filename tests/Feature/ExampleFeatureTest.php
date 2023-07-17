<?php

namespace PrinceJohn\LaravelConfigBuilder\Test\Feature;

class ExampleFeatureTest extends BaseTestCase
{
    /** @test */
    public function it_is_true()
    {            
        $this->artisan('config:build')->assertExitCode(0);
        $this->assertTrue(true);
    }
}
