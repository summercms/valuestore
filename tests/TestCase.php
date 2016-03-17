<?php

namespace Spatie\Valuestore\Test;

use Spatie\Valuestore\ValuestoreServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [ValuestoreServiceProvider::class];
    }
}
