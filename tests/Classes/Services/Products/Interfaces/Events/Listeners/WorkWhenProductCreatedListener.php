<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Events\Listeners;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Events\ProductCreatedEvent;

final class WorkWhenProductCreatedListener
{
    public function handle(ProductCreatedEvent $event): void
    {
    }
}
