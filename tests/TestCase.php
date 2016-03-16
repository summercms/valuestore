<?php

namespace Spatie\Valuestore\Test;


use Spatie\Valuestore\ValuestoreServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    protected function getPackageProviders($app)
    {
        return [ValuestoreServiceProvider::class];
    }
    public function getEnvironmentSetUp($app)
    {

    }
}
