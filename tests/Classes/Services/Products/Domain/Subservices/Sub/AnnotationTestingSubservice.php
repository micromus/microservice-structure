<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\Sub;

use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\AnnotationProductWithTestingInterface;

final class AnnotationTestingSubservice implements AnnotationProductWithTestingInterface
{
    public function annotationProductWithTesting(): void
    {}
}
