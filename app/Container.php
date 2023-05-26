<?php declare(strict_types=1);

namespace ArticlesApp;

use DI\ContainerBuilder;

class Container
{
    private \DI\Container $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/../config.php');
        $this->container = $containerBuilder->build();
    }

    public function getContainer(): \DI\Container
    {
        return $this->container;
    }
}