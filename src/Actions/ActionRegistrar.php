<?php

namespace Micromus\MicroserviceStructure\Actions;

use Illuminate\Support\Str;
use ReflectionException;
use Symfony\Component\Finder\Finder;

final class ActionRegistrar
{
    /**
     * @param  string  $rootNamespace
     * @param  string  $subservicesPath
     * @return void
     */
    public function __construct(
        protected string $rootNamespace,
        protected string $subservicesPath
    ) {
    }

    /**
     * @return array<class-string, class-string>
     *
     * @throws ReflectionException
     */
    public function actions(): array
    {
        $actions = [
            'default' => [],
            'testing' => []
        ];

        $files = (new Finder())
            ->files()
            ->name('*.php')
            ->in($this->subservicesPath)
            ->sortByName();

        foreach ($files as $file) {
            $subserviceClass = $this->getClassByPath($file->getPath().DIRECTORY_SEPARATOR.$file->getFilename());
            $subserviceActions = ClassActionAttribute::getActionsByClass($subserviceClass);

            $actions['default'] = array_merge($actions['default'], $subserviceActions['default'] ?? []);
            $actions['testing'] = array_merge($actions['testing'], $subserviceActions['testing'] ?? []);
        }

        return $actions;
    }

    /**
     * @param  string  $path
     * @return string
     */
    private function getClassByPath(string $path): string
    {
        $class = Str::of($path)
            ->replaceFirst($this->subservicesPath, '')
            ->replace(DIRECTORY_SEPARATOR, '\\')
            ->replaceLast('.php', '');

        return $this->rootNamespace.$class;
    }

    /**
     * @param  string  $rootNamespace
     * @param  string  $subservicesPath
     * @return array
     *
     * @throws ReflectionException
     */
    public static function getActionsByService(string $rootNamespace, string $subservicesPath): array
    {
        return (new ActionRegistrar($rootNamespace, $subservicesPath))
            ->actions();
    }
}
