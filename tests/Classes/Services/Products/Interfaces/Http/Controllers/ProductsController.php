<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\GetProductByIdInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Http\Resources\ProductDataResource;

final class ProductsController
{
    public function get(GetProductByIdInterface $subservice, int $productId): JsonResource
    {
        return new ProductDataResource($subservice->getProductById($productId));
    }
}
