<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products;

use Micromus\MicroserviceStructure\Services\AbstractServiceProvider;
use Micromus\MicroserviceStructure\Services\ServiceConfigurator;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\CreateProductsTestSubservice;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\ProductsSubservice;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\CreateProductInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\GetProductByIdInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Events\ProductCreatedEvent;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Console\ProductsTestCommand;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Events\Listeners\WorkWhenProductCreatedListener;

final class ProductsServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected array $subServices = [
        CreateProductInterface::class => [
            ProductsSubservice::class,
            CreateProductsTestSubservice::class,
        ],

        GetProductByIdInterface::class => ProductsSubservice::class,
    ];

    /**
     * @var array
     */
    protected array $listeners = [
        ProductCreatedEvent::class => [
            WorkWhenProductCreatedListener::class,
        ],
    ];

    /**
     * @var class-string[]
     */
    protected array $commands = [
        ProductsTestCommand::class,
    ];

    /**
     * @param  ServiceConfigurator  $serviceConfigurator
     * @return void
     */
    protected function configureService(ServiceConfigurator $serviceConfigurator): void
    {
        $serviceConfigurator
            ->usingSubservices($this->subServices)
            ->usingListeners($this->listeners)
            ->usingCommands($this->commands)
            ->usingMigrations()
            ->usingConfig('products')
            ->usingRoutes();
    }
}
