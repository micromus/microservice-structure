<?php

namespace Micromus\MicroserviceStructure\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class RegisterAction
{
    public function __construct(
        public string $interfaceClass,
        public ?string $testingClass = null
    ) {
    }
}
