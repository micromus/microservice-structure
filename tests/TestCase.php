<?php

namespace Micromus\MicroserviceStructure\Tests;

use Micromus\MicroserviceStructure\MicroserviceStructureServiceProvider;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Categories\CategoriesServiceProvider;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\ProductsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MicroserviceStructureServiceProvider::class,
            CategoriesServiceProvider::class,
            ProductsServiceProvider::class,
        ];
    }
}
