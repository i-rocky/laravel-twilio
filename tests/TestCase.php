<?php

namespace Rocky\LaravelTwilio\Tests;

use Faker\Factory;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Rocky\LaravelTwilio\Providers\LaravelTwilioServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../src/database/factories');
    }

    protected function getPackageProviders($app)
    {
        return [LaravelTwilioServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {

    }
}
