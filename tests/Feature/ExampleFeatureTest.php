<?php

namespace PrinceJohn\LaravelConfigBuilder\Test\Feature;

class ExampleFeatureTest extends BaseTestCase
{
    /** @test */
    public function it_is_true()
    {

        $this->withoutExceptionHandling();
        $this->artisan('config:build');
        $this->assertTrue(true);
    }
}
