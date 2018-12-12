<?php

namespace Codeurx\Modular\Tests;

use Codeurx\Modular\ModularServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    protected function getPackageProviders($app)
    {
        return [ModularServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('modular', [
            'table_name'  =>  'modules',
        ]);
    }
}