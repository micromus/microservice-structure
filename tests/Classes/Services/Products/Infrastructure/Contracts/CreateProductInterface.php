<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;

interface CreateProductInterface
{
    public function createProduct(ProductData $productData): ProductData;
}
