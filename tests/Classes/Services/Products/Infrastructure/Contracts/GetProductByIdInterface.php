<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;

interface GetProductByIdInterface
{
    public function getProductById(int $productId): ProductData;
}
