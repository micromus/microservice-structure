<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;

final class ProductDataResource extends JsonResource
{
    /**
     * @var ProductData
     */
    public $resource;

    public function __construct(ProductData $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param  Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
        ];
    }
}
