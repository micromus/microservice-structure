<?php

namespace Micromus\MicroserviceStructure\Services;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Micromus\MicroserviceStructure\Actions\ActionRegistrar;
use ReflectionClass;
use ReflectionException;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * @var ServiceConfigurator
     */
    private ServiceConfigurator $serviceConfigurator;

    /**
     * @var string
     */
    private string $servicePath;

    private array $actions = [];

    private array $testingActions = [];

    /**
     * @param $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->servicePath = $this->getServicePath();
    }

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    public function register(): void
    {
        $this->serviceConfigurator = $this->createConfiguration();
        $this->configureService($this->serviceConfigurator);

        $this->actions = $this->serviceConfigurator
            ->getSubServices();

        $this->testingActions = $this->serviceConfigurator
            ->getTestingSubService();

        $this->registerAnnotationsSubservices();

        $this->registerActions($this->actions);

        if ($this->app->runningUnitTests()) {
            $this->registerActions($this->testingActions);
        }
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->serviceConfigurator->getMigrationsNamespace() !== null) {
            $this->loadMigrationsFrom($this->serviceConfigurator->getMigrationsNamespace());
        }

        if ($this->serviceConfigurator->getRouterFile()) {
            $this->loadRoutesFrom($this->serviceConfigurator->getRouterFile());
        }

        if ($this->app->runningInConsole()) {
            $this->commands($this->serviceConfigurator->getCommands());
        }

        $config = $this->serviceConfigurator
            ->getConfig();

        if ($config != null) {
            $this->mergeConfigFrom($this->serviceConfigurator->getConfigFile(), "services.$config");
        }

        $this->registerListeners($this->serviceConfigurator->getListeners());
    }

    /**
     * @return ServiceConfigurator
     */
    private function createConfiguration(): ServiceConfigurator
    {
        return new ServiceConfigurator($this->servicePath);
    }

    /**
     * @param  ServiceConfigurator  $serviceConfigurator
     * @return void
     */
    abstract protected function configureService(ServiceConfigurator $serviceConfigurator): void;

    /**
     * @param  array  $actions
     * @return void
     */
    private function registerActions(array $actions): void
    {
        foreach ($actions as $contract => $subService) {
            $this->app->bind($contract, $subService);
        }
    }

    /**
     * @param  array  $configureListeners
     * @return void
     */
    private function registerListeners(array $configureListeners): void
    {
        foreach ($configureListeners as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }

    /**
     * @return string
     */
    private function getServicePath(): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName());
    }

    /**
     * @return string
     */
    private function getSubservicesPath(): string
    {
        $subserviceNamespace = $this->serviceConfigurator->getSubserviceNamespace();
        $directory = Str::replace('\\', DIRECTORY_SEPARATOR, $subserviceNamespace);

        return $this->servicePath.DIRECTORY_SEPARATOR.$directory;
    }

    /**
     * @return string
     */
    private function getRootNamespace(): string
    {
        return Str::replaceLast('\\'.class_basename($this), '', get_class($this));
    }

    /**
     * @return string
     */
    private function getSubservicesNamespace(): string
    {
        return $this->getRootNamespace().'\\'.$this->serviceConfigurator->getSubserviceNamespace();
    }

    /**
     * @return void
     *
     * @throws ReflectionException
     */
    private function registerAnnotationsSubservices(): void
    {
        $subservicesPath = $this->getSubservicesPath();
        $rootNamespace = $this->getSubservicesNamespace();

        if (is_dir($subservicesPath)) {
            $actions = $this->getActions($rootNamespace, $subservicesPath);

            config()
                ->set("microservice-structure.actions.$rootNamespace", $actions);

            $this->actions = array_merge($this->actions, $actions['default'] ?? []);
            $this->testingActions = array_merge($this->testingActions, $actions['testing'] ?? []);
        }
    }

    /**
     * @param  string  $rootNamespace
     * @param  string  $subservicesPath
     * @return array<class-string, class-string>
     *
     * @throws ReflectionException
     */
    private function getActions(string $rootNamespace, string $subservicesPath): array
    {
        return config()->has("microservice-structure.actions.$rootNamespace")
            ? config("microservice-structure.actions.$rootNamespace")
            : ActionRegistrar::getActionsByService($rootNamespace, $subservicesPath);
    }
}
