<?php

namespace Jheckdoc\Jheckdoc\Tests;

use Orchestra\Testbench\TestCase;
use Jheckdoc\Jheckdoc\JheckdocServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [JheckdocServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
