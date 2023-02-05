<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects;

final class ProductData
{
    public function __construct(
        public int|null $id,
        public string $title
    ) {
    }
}
