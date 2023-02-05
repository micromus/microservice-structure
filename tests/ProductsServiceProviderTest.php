<?php

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Event;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Events\ProductCreatedEvent;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Exceptions\NotAllowedTestingException;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Application\Listeners\WorkWhenProductCreatedListener;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\Sub\AnnotationProductsSubservice;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\AnnotationProductInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\CreateProductInterface;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\DataTransferObjects\ProductData;
use function Pest\Laravel\get;

it('get replace subservice into testing subservices', function () {
    app(CreateProductInterface::class)
        ->createProduct(new ProductData(1, 'Test product'));
})->throws(NotAllowedTestingException::class);

it('register service by annotations', function () {
    expect(app(AnnotationProductInterface::class))
        ->toBeInstanceOf(AnnotationProductsSubservice::class);
});

it('check apply service migrations', function () {
    /** @var Migrator $migrator */
    $migrator = app('migrator');

    $this->assertArrayHasKey('create_products_table', $migrator->getMigrationFiles($migrator->paths()));
});

it('get product by id from controller', function () {
    get('products/1')
        ->assertOk()
        ->assertJsonPath('data.id', 1);
});

it('test listener to events', function () {
    Event::fake();

    Event::assertListening(
        ProductCreatedEvent::class,
        WorkWhenProductCreatedListener::class
    );
});

it('run service command', function () {
    $this->artisan('products:test')
        ->assertSuccessful();
});

it('get config values', function () {
    expect(config('services.products.pagination'))
        ->toBe(10);
});
