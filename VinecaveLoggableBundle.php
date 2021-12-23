<?php

namespace Vinecave\Bundle\LoggableBundle;

use Vinecave\Bundle\LoggableBundle\DependencyInjection\LoggableCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class VinecaveLoggableBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new LoggableCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 100);
    }
}
