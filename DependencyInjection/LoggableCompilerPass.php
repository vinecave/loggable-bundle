<?php

namespace Vinecave\Bundle\LoggableBundle\DependencyInjection;

use Vinecave\Bundle\LoggableBundle\Behavior\LoggableInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggableCompilerPass implements CompilerPassInterface
{
    private const INCLUSIVE = 'inclusive';

    public function process(ContainerBuilder $container)
    {
        $loggableServices = $container->findTaggedServiceIds(LoggableInterface::class);

        $handlersToChannels = [];
        $channelList = [];

        foreach ($loggableServices as $id => $tags) {
            $service = $container->getDefinition(
                $id
            );

            $class = $service->getClass();

            if (false === is_a($class, LoggableInterface::class, true)) {
                continue;
            }

            if (false === $class::isLogged()) {
                continue;
            }

            $channelName = 'loggable_' . $class::getName();
            $handlerName = 'monolog.handler.' . $channelName;

            $service->addTag(
                'monolog.logger',
                [
                    'channel' => $channelName
                ]
            );

            $loggerDefinition = new Definition(StreamHandler::class);

            $loggerDefinition->setArguments([
                '%kernel.logs_dir%/%kernel.environment%_' . $channelName . '.log',
                Logger::DEBUG,
            ]);

            $container->setDefinition($handlerName, $loggerDefinition);

            $channelList[] = $channelName;

            $handlersToChannels[$handlerName] = [
                'type' => self::INCLUSIVE,
                'elements' => [
                    $channelName
                ],
            ];
        }

        $existingHandlerToChannels = $container->getParameter('monolog.handlers_to_channels');

        $existingHandlerToChannels += $handlersToChannels;
        
        if (empty($existingHandlerToChannels)) {
            $existingHandlerToChannels = [];
        }

        $container->setParameter('monolog.handlers_to_channels', $existingHandlerToChannels);
    }
}
