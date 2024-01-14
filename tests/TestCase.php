<?php

namespace Nerbiz\CrawlShield\Tests;

use Nerbiz\CrawlShield\CrawlShieldServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CrawlShieldServiceProvider::class,
        ];
    }
}
