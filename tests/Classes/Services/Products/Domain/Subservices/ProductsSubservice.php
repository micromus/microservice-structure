<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\CreateProductInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\GetProductByIdInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;

final class ProductsSubservice implements GetProductByIdInterface, CreateProductInterface
{
    public function createProduct(ProductData $productData): ProductData
    {
        return $productData;
    }

    public function getProductById(int $productId): ProductData
    {
        return new ProductData($productId, 'Testing Product');
    }
}
