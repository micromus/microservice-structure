<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Listeners;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Events\ProductCreatedEvent;

final class WorkWhenProductCreatedListener
{
    public function handle(ProductCreatedEvent $event): void
    {
    }
}
