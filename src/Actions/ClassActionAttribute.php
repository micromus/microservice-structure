<?php

namespace Micromus\MicroserviceStructure\Actions;

use Micromus\MicroserviceStructure\Attributes\RegisterAction;
use ReflectionClass;
use ReflectionException;

final class ClassActionAttribute
{
    /**
     * @param  ReflectionClass  $class
     * @return void
     */
    public function __construct(
        protected ReflectionClass $class
    ) {
    }

    /**
     * @return array<class-string, class-string>
     */
    public function actions(): array
    {
        $actions = [
            'default' => [],
            'testing' => []
        ];

        foreach ($this->class->getMethods() as $method) {
            $attributes = $method->getAttributes(RegisterAction::class);

            foreach ($attributes as $attribute) {
                /** @var RegisterAction $instanceAttribute */
                $instanceAttribute = $attribute->newInstance();
                $actions['default'][$instanceAttribute->interfaceClass] = $this->class->name;

                if ($instanceAttribute->testingClass) {
                    $actions['testing'][$instanceAttribute->interfaceClass] = $instanceAttribute->testingClass;
                }
            }
        }

        return $actions;
    }

    /**
     * @param  string  $class
     * @return array<class-string, class-string>
     *
     * @throws ReflectionException
     */
    public static function getActionsByClass(string $class): array
    {
        return (new ClassActionAttribute(new ReflectionClass($class)))
            ->actions();
    }
}
