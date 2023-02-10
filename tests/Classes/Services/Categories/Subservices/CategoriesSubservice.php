<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Categories\Subservices;

use Micromus\MicroserviceStructure\Attributes\RegisterAction;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Categories\Infrastructure\Contracts\GetCategoriesInterface;

final class CategoriesSubservice implements GetCategoriesInterface
{
    #[RegisterAction(GetCategoriesInterface::class)]
    public function getCategories(): array
    {
        return [['id' => 1, 'title' => 'Тестовая категория']];
    }
}
