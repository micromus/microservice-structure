<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Domain\Subservices\Sub;

use Micromus\MicroserviceStructure\Attributes\RegisterAction;
use Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Infrastructure\Contracts\AnnotationProductInterface;

final class AnnotationProductsSubservice implements AnnotationProductInterface
{
    #[RegisterAction(AnnotationProductInterface::class)]
    public function annotationProduct(): string
    {
        return 'Hello world';
    }
}
