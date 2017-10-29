<?php

namespace Davison\CsrfProtectedRoutingBundle;

use Davison\CsrfProtectedRoutingBundle\DependencyInjection\Compiler\UrlGeneratorOverrideCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CsrfProtectedRoutingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new UrlGeneratorOverrideCompilerPass());
    }
}