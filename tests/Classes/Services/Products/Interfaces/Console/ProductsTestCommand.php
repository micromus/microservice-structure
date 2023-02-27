<?php

namespace Micromus\MicroserviceStructure\Tests\Classes\Services\Products\Interfaces\Console;

use Illuminate\Console\Command;

final class ProductsTestCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'products:test';

    public function handle(): int
    {
        return self::SUCCESS;
    }
}
