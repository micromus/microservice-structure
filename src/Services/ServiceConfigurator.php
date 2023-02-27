<?php

namespace Micromus\MicroserviceStructure\Services;

use Illuminate\Support\Arr;

final class ServiceConfigurator
{
    /**
     * @var array<class-string, class-string>
     */
    protected array $subServices = [];

    /**
     * @var array<class-string, class-string>
     */
    protected array $testingSubService = [];

    protected string $subserviceNamespace = 'Domain\\Subservices';

    protected array $listeners = [];

    protected array $commands = [];

    protected string|null $migrationsNamespace = null;

    protected string|null $routerFile = null;

    protected string|null $config = null;

    public function __construct(
        protected string $servicePath
    ) {
    }

    public function getSubServices(): array
    {
        return $this->subServices;
    }

    public function getTestingSubService(): array
    {
        return $this->testingSubService;
    }

    public function getSubserviceNamespace(): string
    {
        return $this->subserviceNamespace;
    }

    public function getListeners(): array
    {
        return $this->listeners;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function getMigrationsNamespace(): ?string
    {
        return $this->migrationsNamespace;
    }

    public function getRouterFile(): ?string
    {
        return $this->routerFile;
    }

    public function getConfigFile(): string
    {
        return $this->servicePath.DIRECTORY_SEPARATOR.'Domain'.DIRECTORY_SEPARATOR.'config.php';
    }

    public function getConfig(): ?string
    {
        return $this->config;
    }

    public function setSubserviceNamespace(string $subserviceNamespace = 'Domain\\Subservices'): ServiceConfigurator
    {
        $this->subserviceNamespace = $subserviceNamespace;

        return $this;
    }

    /**
     * @return $this
     */
    public function usingSubservices(array $subServices): self
    {
        $subServices = array_map(
            fn ($subService) => Arr::wrap($subService),
            $subServices
        );

        foreach ($subServices as $contract => $subService) {
            $this->addSubservice($contract, $subService[0], $subService[1] ?? null);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function usingListeners(array $listeners): self
    {
        $this->listeners = $listeners;

        return $this;
    }

    /**
     * @return $this
     */
    public function usingCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * @return $this
     */
    public function usingMigrations(string $namespace = 'Application/Database/Migrations'): self
    {
        $this->migrationsNamespace = $this->servicePath.DIRECTORY_SEPARATOR.$namespace;

        return $this;
    }

    /**
     * @return $this
     */
    public function usingRoutes(): self
    {
        $this->routerFile = $this->servicePath
            .DIRECTORY_SEPARATOR
            .'Interfaces'
            .DIRECTORY_SEPARATOR
            .'Http'
            .DIRECTORY_SEPARATOR
            .'routes.php';

        return $this;
    }

    /**
     * @return $this
     */
    public function usingConfig(string $serviceName): self
    {
        $this->config = $serviceName;

        return $this;
    }

    /**
     * @return $this
     */
    protected function addSubservice(string $contract, string $subService, string $testSubService = null): self
    {
        $this->subServices[$contract] = $subService;

        if ($testSubService !== null) {
            $this->testingSubService[$contract] = $testSubService;
        }

        return $this;
    }
}
