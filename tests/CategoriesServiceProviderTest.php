<?php

use Micromus\MicroserviceStructure\Tests\Classes\Services\Categories\Infrastructure\Contracts\GetCategoriesInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Categories\Subservices\CategoriesSubservice;

it('register custom directory subservices', function () {
    expect(app(GetCategoriesInterface::class))
        ->toBeInstanceOf(CategoriesSubservice::class);
});
