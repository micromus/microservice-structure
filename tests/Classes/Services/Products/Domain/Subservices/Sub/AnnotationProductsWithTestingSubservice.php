<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\Sub;

use Micromus\MicroserviceStructure\Attributes\RegisterAction;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\AnnotationProductWithTestingInterface;

final class AnnotationProductsWithTestingSubservice implements AnnotationProductWithTestingInterface
{
    #[RegisterAction(AnnotationProductWithTestingInterface::class, AnnotationTestingSubservice::class)]
    public function annotationProductWithTesting(): void
    {
    }
}
