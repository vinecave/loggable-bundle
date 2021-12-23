<?php

namespace Vinecave\Bundle\LoggableBundle\DependencyInjection;

use Vinecave\Bundle\LoggableBundle\Behavior\LoggableInterface;
use Vinecave\Bundle\CollectionBundle\Container\AbstractExtension;;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class VinecaveLoggableExtension extends AbstractExtension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(LoggableInterface::class)
            ->addTag(LoggableInterface::class);

        $this->loadExtension($container, __DIR__);
    }
}
