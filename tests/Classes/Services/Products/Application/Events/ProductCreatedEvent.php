<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Events;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;

final class ProductCreatedEvent
{
    public function __construct(
        public ProductData $product
    ) {
    }
}
