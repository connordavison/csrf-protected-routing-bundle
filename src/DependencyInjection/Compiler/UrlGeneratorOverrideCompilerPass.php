<?php

namespace Davison\CsrfProtectedRoutingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UrlGeneratorOverrideCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('twig.extension.routing')) {
            // Decorate the URL generator used by the default RoutingExtension
            $routing = $container->getDefinition('twig.extension.routing');
            $defaultUrlGenerator = $routing->getArgument(0);
            $routing->replaceArgument(0, new Reference('csrf_protected_routing.routing.url_generator'));
            $container->getDefinition('csrf_protected_routing.routing.url_generator')
                ->setArgument(0, $defaultUrlGenerator);
        }
    }
}