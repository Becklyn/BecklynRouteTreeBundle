<?php

declare(strict_types=1);

namespace Becklyn\RouteTreeBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 *
 */
class BecklynRouteTreeBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getContainerExtension ()
    {
        return new class() extends Extension {
            /**
             * @inheritDoc
             */
            public function load(array $configs, ContainerBuilder $container) : void
            {
                $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
                $loader->load('services.yaml');
            }
        };
    }
}
